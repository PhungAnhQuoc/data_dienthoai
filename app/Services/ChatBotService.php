<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\Product;
use App\Models\Category;

class ChatBotService
{
    /**
     * Detect user intent and respond
     */
    public static function getResponse($message, $sessionId)
    {
        // Save user message
        ChatMessage::create([
            'session_id' => $sessionId,
            'type' => 'user',
            'message' => $message,
            'intent' => self::detectIntent($message),
        ]);

        $intent = self::detectIntent($message);
        $response = self::generateResponse($message, $intent);

        // Save bot response
        ChatMessage::create([
            'session_id' => $sessionId,
            'type' => 'bot',
            'message' => $response['text'],
            'intent' => $intent,
            'product_id' => $response['product_id'] ?? null,
        ]);

        return $response;
    }

    /**
     * Detect user intent
     */
    public static function detectIntent($message)
    {
        $message = strtolower($message);

        // Keyword detection - more comprehensive
        $intents = [
            'product' => [
                // Product search keywords
                'sản phẩm', 'có bán', 'loại', 'dòng', 'model', 'cái nào', 
                'tìm', 'search', 'iphone', 'ipad', 'samsung', 'nokia', 'xiaomi', 
                'realme', 'oppo', 'vivo', 'laptop', 'máy tính', 'phụ kiện', 'pin', 'sạc',
                'tai nghe', 'cáp', 'case', 'kính cường lực', 'ốp', 'bao',
                // Question patterns
                'có không', 'bán không', 'còn không', 'giống', 'như'
            ],
            'category' => ['điện thoại', 'laptop', 'máy tính', 'phụ kiện', 'pin', 'sạc', 'danh mục'],
            'price' => ['bao nhiêu', 'giá', 'rẻ', 'khuyến mãi', 'sale', 'discount', 'giảm', 'đắt'],
            'delivery' => ['giao', 'ship', 'vận chuyển', 'mất bao lâu', 'bao lâu', 'tốc độ', 'nhanh', 'phí'],
            'payment' => ['thanh toán', 'trả tiền', 'cách nào', 'bằng gì', 'vtpay', 'ví', 'card', 'bank'],
            'service' => ['dịch vụ', 'bảo hành', 'hỗ trợ', 'giúp', 'tư vấn', 'đổi', 'trả'],
            'greeting' => ['hello', 'hi', 'chào', 'xin chào', 'tạm biệt', 'bye', 'hôm nay'],
        ];

        // Check priority - if message has product keywords, it's a product query
        foreach ($intents['product'] as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return 'product';
            }
        }

        // Then check other intents
        foreach ($intents as $intent => $keywords) {
            if ($intent === 'product') continue; // Already checked
            
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    return $intent;
                }
            }
        }

        return 'general';
    }

    /**
     * Generate bot response
     */
    public static function generateResponse($message, $intent)
    {
        $message = strtolower($message);

        switch ($intent) {
            case 'product':
                return self::handleProductQuery($message);
            
            case 'category':
                return self::handleCategoryQuery($message);
            
            case 'price':
                return self::handlePriceQuery($message);
            
            case 'delivery':
                return self::handleDeliveryQuery();
            
            case 'payment':
                return self::handlePaymentQuery();
            
            case 'service':
                return self::handleServiceQuery();
            
            case 'greeting':
                return self::handleGreeting($message);
            
            default:
                return self::handleGeneral();
        }
    }

    /**
     * Handle product queries
     */
    private static function handleProductQuery($message)
    {
        // Extract keywords from message
        $keywords = self::extractProductKeywords($message);
        
        // First, try to find by specific product names
        $products = Product::where('is_active', true)
            ->where(function($q) use ($message, $keywords) {
                // Search in product name
                $q->where('name', 'like', "%{$message}%");
                
                // Search for each keyword
                foreach ($keywords as $keyword) {
                    $q->orWhere('name', 'like', "%{$keyword}%")
                      ->orWhere('description', 'like', "%{$keyword}%");
                }
            })
            ->limit(5)
            ->get();

        // If no results, try category search
        if ($products->isEmpty() && !empty($keywords)) {
            $categories = Category::where('is_active', true)
                ->where(function($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->orWhere('name', 'like', "%{$keyword}%");
                    }
                })
                ->pluck('id');

            if ($categories->isNotEmpty()) {
                $products = Product::where('is_active', true)
                    ->whereIn('category_id', $categories)
                    ->limit(5)
                    ->get();
            }
        }

        if ($products->isNotEmpty()) {
            $text = "✨ Chúng tôi tìm thấy " . count($products) . " sản phẩm phù hợp:";
            
            // Build product cards data
            $productCards = [];
            foreach ($products as $product) {
                $price = $product->sale_price ?? $product->price;
                $originalPrice = $product->price;
                $discount = null;
                
                if ($product->sale_price && $product->sale_price < $product->price) {
                    $discount = round((1 - $product->sale_price / $product->price) * 100);
                }
                
                $productUrl = route('products.show', ['slug' => $product->slug]);
                
                $productCards[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $price,
                    'originalPrice' => $originalPrice,
                    'discount' => $discount,
                    'stock' => $product->stock,
                    'brand' => $product->brand_id ? \App\Models\Brand::find($product->brand_id)?->name : null,
                    'image' => $product->images()->first()?->image_url ?? 'https://via.placeholder.com/150',
                    'url' => $productUrl,
                    'slug' => $product->slug,
                ];
            }

            return [
                'text' => $text,
                'product_id' => $products->first()->id,
                'products' => $productCards,
                'type' => 'products',
            ];
        }

        // If still no results, suggest alternatives
        $text = "😅 Xin lỗi, chúng tôi hiện chưa có sản phẩm đó.\n\n";
        $text .= "💡 Bạn có thể thử:\n";
        $text .= "• Tìm kiếm với tên khác\n";
        $text .= "• Xem danh mục sản phẩm\n";
        $text .= "• Liên hệ tư vấn viên: 0123.456.789\n\n";
        $text .= "👉 Hay bạn muốn xem sản phẩm nào khác?";

        return ['text' => $text];
    }

    /**
     * Extract product keywords from message
     */
    private static function extractProductKeywords($message)
    {
        $message = strtolower($message);
        
        // Remove common Vietnamese words
        $commonWords = [
            'có', 'bán', 'gì', 'cái', 'dòng', 'loại', 'không', 'khác', 
            'nào', 'được', 'như', 'của', 'à', 'ạ', 'ư', 'ấy', 'này'
        ];
        
        // Split message into words
        $words = preg_split('/[\s,।।]+/', $message, -1, PREG_SPLIT_NO_EMPTY);
        
        // Filter out common words and very short words
        $keywords = array_filter($words, function($word) use ($commonWords) {
            return !in_array($word, $commonWords) && strlen($word) > 2;
        });
        
        return array_values($keywords);
    }

    /**
     * Handle category queries
     */
    private static function handleCategoryQuery($message)
    {
        $categories = Category::where('is_active', true)->get();
        
        $text = "Chúng tôi có các danh mục sau:\n\n";
        foreach ($categories as $cat) {
            $count = Product::where('category_id', $cat->id)->where('is_active', true)->count();
            $text .= "📂 " . $cat->name . " (" . $count . " sản phẩm)\n";
        }
        $text .= "\n👉 Chọn danh mục bạn muốn xem!";

        return ['text' => $text];
    }

    /**
     * Handle price queries
     */
    private static function handlePriceQuery($message)
    {
        $promoText = "🎉 Chúng tôi thường xuyên có khuyến mãi!\n\n";
        $promoText .= "✨ Các sản phẩm sale:\n";
        
        $saleProducts = Product::where('is_active', true)
            ->whereNotNull('sale_price')
            ->limit(3)
            ->get();

        if ($saleProducts->isNotEmpty()) {
            foreach ($saleProducts as $product) {
                $discount = round((1 - $product->sale_price / $product->price) * 100);
                $promoText .= "💥 " . $product->name . "\n";
                $promoText .= "   Giá: " . number_format($product->sale_price, 0, ',', '.') . "đ\n";
                $promoText .= "   Giảm: -" . $discount . "%\n\n";
            }
        }
        
        $promoText .= "👉 Ghé thăm trang khuyến mãi của chúng tôi!";

        return ['text' => $promoText];
    }

    /**
     * Handle delivery queries
     */
    private static function handleDeliveryQuery()
    {
        $text = "📦 Thông tin giao hàng:\n\n";
        $text .= "⏱️ Thời gian giao hàng:\n";
        $text .= "   • Nội thành: 1-2 ngày\n";
        $text .= "   • Ngoài thành: 2-3 ngày\n";
        $text .= "   • Các tỉnh khác: 3-5 ngày\n\n";
        $text .= "🚚 Phí vận chuyển:\n";
        $text .= "   • Miễn phí cho đơn từ 500.000đ\n";
        $text .= "   • Khác: 25.000đ - 50.000đ\n\n";
        $text .= "👉 Bạn có thắc mắc gì khác không?";

        return ['text' => $text];
    }

    /**
     * Handle payment queries
     */
    private static function handlePaymentQuery()
    {
        $text = "💳 Phương thức thanh toán:\n\n";
        $text .= "1️⃣ Thanh toán khi nhận hàng (COD)\n";
        $text .= "2️⃣ Chuyển khoản ngân hàng\n";
        $text .= "3️⃣ Ví điện tử (VNPay, Momo, Zalo Pay)\n";
        $text .= "4️⃣ Thẻ tín dụng\n\n";
        $text .= "✅ Tất cả phương thức đều an toàn và bảo mật!\n\n";
        $text .= "👉 Bạn muốn thanh toán bằng cách nào?";

        return ['text' => $text];
    }

    /**
     * Handle service queries
     */
    private static function handleServiceQuery()
    {
        $text = "🛠️ Các dịch vụ của chúng tôi:\n\n";
        $text .= "🔧 Bảo hành: Toàn bộ sản phẩm đều có bảo hành chính hãng\n";
        $text .= "🆓 Hỗ trợ kỹ thuật: Miễn phí trong 1 năm đầu\n";
        $text .= "📞 Tư vấn miễn phí: Gọi cho chúng tôi để tư vấn\n";
        $text .= "⚡ Cài đặt: Cài đặt miễn phí cho các sản phẩm lớn\n";
        $text .= "♻️ Đổi trả: Dễ dàng đổi trả trong 7 ngày\n\n";
        $text .= "📞 Liên hệ: 0123.456.789\n";
        $text .= "📧 Email: support@mobileshop.com\n\n";
        $text .= "👉 Bạn cần hỗ trợ gì?";

        return ['text' => $text];
    }

    /**
     * Handle greetings
     */
    private static function handleGreeting($message)
    {
        $greetings = [
            'Xin chào bạn! 👋 Chào mừng đến với Mobile Shop!\n\nChúng tôi có thể giúp gì cho bạn?\n• 📱 Tìm sản phẩm\n• 💳 Thanh toán\n• 📦 Giao hàng\n• 🛠️ Hỗ trợ',
            'Hí bạn! 🎉 Rất vui được gặp bạn!\n\nTôi có thể tư vấn về:\n• Sản phẩm mới\n• Khuyến mãi đang diễn ra\n• Giá cả\n• Dịch vụ',
            'Chào! 😊 Tôi là bot tư vấn của Mobile Shop.\n\nBạn muốn tìm gì? Hãy nói cho tôi biết!',
        ];

        if (strpos($message, 'bye') !== false || strpos($message, 'tạm biệt') !== false) {
            return ['text' => 'Tạm biệt bạn! 👋 Cảm ơn bạn đã ghé thăm Mobile Shop.\n\n📞 Liên hệ chúng tôi nếu cần hỗ trợ!'];
        }

        return ['text' => $greetings[array_rand($greetings)]];
    }

    /**
     * Handle general queries
     */
    private static function handleGeneral()
    {
        $text = "😊 Cảm ơn bạn đã hỏi!\n\n";
        $text .= "Tôi là bot tư vấn của Mobile Shop. Tôi có thể giúp bạn:\n";
        $text .= "• 🔍 Tìm sản phẩm\n";
        $text .= "• 💰 Kiểm tra giá\n";
        $text .= "• 📦 Tư vấn vận chuyển\n";
        $text .= "• 💳 Hướng dẫn thanh toán\n";
        $text .= "• 🛠️ Thông tin dịch vụ\n\n";
        $text .= "👉 Hãy hỏi tôi điều gì bạn cần!";

        return ['text' => $text];
    }

    /**
     * Get session history
     */
    public static function getHistory($sessionId)
    {
        return ChatMessage::getSessionMessages($sessionId);
    }

    /**
     * Rate conversation
     */
    public static function rateConversation($sessionId, $rating)
    {
        ChatMessage::where('session_id', $sessionId)
            ->where('type', 'bot')
            ->latest()
            ->first()
            ?->update(['rating' => $rating]);

        return true;
    }
}
