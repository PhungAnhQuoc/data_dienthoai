<?php

if (!function_exists('meta_tags')) {
    /**
     * Generate meta tags for SEO
     */
    function meta_tags($title, $description, $keywords = '', $image = '')
    {
        $meta = "<title>" . htmlspecialchars($title) . " - " . config('app.name') . "</title>\n";
        $meta .= "<meta name=\"description\" content=\"" . htmlspecialchars(substr($description, 0, 160)) . "\">\n";
        
        if ($keywords) {
            $meta .= "<meta name=\"keywords\" content=\"" . htmlspecialchars($keywords) . "\">\n";
        }

        // Open Graph tags
        $meta .= "<meta property=\"og:title\" content=\"" . htmlspecialchars($title) . "\">\n";
        $meta .= "<meta property=\"og:description\" content=\"" . htmlspecialchars(substr($description, 0, 160)) . "\">\n";
        $meta .= "<meta property=\"og:type\" content=\"website\">\n";
        $meta .= "<meta property=\"og:url\" content=\"" . url()->current() . "\">\n";

        if ($image) {
            $meta .= "<meta property=\"og:image\" content=\"" . htmlspecialchars(asset($image)) . "\">\n";
        }

        // Twitter Card
        $meta .= "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
        $meta .= "<meta name=\"twitter:title\" content=\"" . htmlspecialchars($title) . "\">\n";
        $meta .= "<meta name=\"twitter:description\" content=\"" . htmlspecialchars(substr($description, 0, 160)) . "\">\n";

        return $meta;
    }
}

if (!function_exists('schema_product')) {
    /**
     * Generate product schema.org JSON-LD
     */
    function schema_product($product)
    {
        $schema = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $product->description,
            'image' => asset("storage/{$product->main_image}"),
            'brand' => [
                '@type' => 'Brand',
                'name' => $product->brand->name ?? '',
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => route('products.show', $product->slug),
                'priceCurrency' => 'VND',
                'price' => $product->sale_price ?? $product->price,
                'availability' => $product->stock > 0 ? 'InStock' : 'OutOfStock',
            ],
        ];

        // Add rating if exists
        if ($product->reviews()->exists()) {
            $avgRating = $product->reviews()->where('is_approved', true)->avg('rating');
            $ratingCount = $product->reviews()->where('is_approved', true)->count();

            if ($avgRating) {
                $schema['aggregateRating'] = [
                    '@type' => 'AggregateRating',
                    'ratingValue' => round($avgRating, 1),
                    'ratingCount' => $ratingCount,
                ];
            }
        }

        return json_encode($schema);
    }
}

if (!function_exists('schema_organization')) {
    /**
     * Generate organization schema.org JSON-LD
     */
    function schema_organization()
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'sameAs' => [
                'https://facebook.com/yourpage',
                'https://twitter.com/yourhandle',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'Customer Service',
                'telephone' => env('APP_PHONE', ''),
                'email' => env('MAIL_FROM_ADDRESS', ''),
            ],
        ];

        return json_encode($schema);
    }
}

if (!function_exists('canonical_link')) {
    /**
     * Generate canonical link tag
     */
    function canonical_link($url = null)
    {
        $url = $url ?? url()->current();
        return "<link rel=\"canonical\" href=\"" . htmlspecialchars($url) . "\">\n";
    }
}
