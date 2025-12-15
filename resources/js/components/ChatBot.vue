<template>
  <div class="chatbot-widget">
    <!-- Floating Button -->
    <button 
      v-if="!isOpen" 
      @click="openChat" 
      class="chat-button"
      title="Nhấn để chat với chúng tôi"
    >
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
      </svg>
      <span class="unread-badge" v-if="unreadCount > 0">{{ unreadCount }}</span>
    </button>

    <!-- Chat Window -->
    <div v-if="isOpen" class="chat-window">
      <!-- Header -->
      <div class="chat-header">
        <div class="chat-header-title">
          <h3>💬 Mobile Shop Chat</h3>
          <p class="status">Chúng tôi sẵn sàng hỗ trợ 24/7</p>
        </div>
        <button @click="closeChat" class="close-btn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>

      <!-- Messages -->
      <div class="chat-messages" ref="messagesContainer">
        <div v-if="messages.length === 0" class="welcome-message">
          <div class="welcome-icon">👋</div>
          <h4>Xin chào! 👋</h4>
          <p>Tôi là bot tư vấn của Mobile Shop. Hãy hỏi tôi về sản phẩm hoặc dịch vụ!</p>
          <div class="quick-questions">
            <button 
              v-for="question in quickQuestions" 
              :key="question"
              @click="sendQuickMessage(question)"
              class="quick-btn"
            >
              {{ question }}
            </button>
          </div>
        </div>

        <div 
          v-for="(msg, idx) in messages" 
          :key="idx"
          :class="['message', msg.type]"
        >
          <div class="message-content">
            <!-- Debug: show if products exist -->
            <div v-if="msg.products" style="background: lime; padding: 5px; margin-bottom: 5px;">
              DEBUG: products = {{ msg.products.length }} items
            </div>
            
            <!-- Text message -->
            <p v-if="!msg.products || msg.products.length === 0">{{ msg.message }}</p>
            
            <!-- Product cards -->
            <div v-else-if="msg.products && msg.products.length > 0" class="product-cards-container">
              <p class="products-header">{{ msg.message }}</p>
              <div class="product-cards">
                <a 
                  v-for="product in msg.products" 
                  :key="product.id"
                  :href="product.url"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="product-card"
                >
                  <div class="product-image">
                    <img :src="product.image" :alt="product.name" />
                    <span v-if="product.discount" class="discount-badge">
                      -{{ product.discount }}%
                    </span>
                  </div>
                  <div class="product-info">
                    <h4>{{ product.name }}</h4>
                    <p v-if="product.brand" class="brand">{{ product.brand }}</p>
                    <div class="price-section">
                      <span v-if="product.discount" class="original-price">
                        {{ formatPrice(product.originalPrice) }}
                      </span>
                      <span class="current-price">{{ formatPrice(product.price) }}đ</span>
                    </div>
                    <div class="stock-status">
                      <span v-if="product.stock > 0" class="in-stock">✅ Còn hàng</span>
                      <span v-else class="out-of-stock">❌ Hết hàng</span>
                    </div>
                    <div class="action-button">Xem chi tiết →</div>
                  </div>
                </a>
              </div>
            </div>
            
            <span class="message-time">{{ msg.time }}</span>
          </div>
        </div>

        <!-- Typing indicator -->
        <div v-if="isLoading" class="message bot">
          <div class="message-content">
            <div class="typing-indicator">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Rating -->
      <div v-if="showRating" class="chat-rating">
        <p>Bạn có hài lòng với trợ giúp của tôi không?</p>
        <div class="rating-stars">
          <button 
            v-for="star in 5" 
            :key="star"
            @click="rateConversation(star)"
            class="star"
            :class="{ active: rating === star }"
          >
            ⭐
          </button>
        </div>
      </div>

      <!-- Input -->
      <div class="chat-input-area">
        <form @submit.prevent="sendMessage">
          <div class="input-wrapper">
            <input 
              v-model="userMessage" 
              type="text"
              placeholder="Gõ tin nhắn..."
              :disabled="isLoading"
              class="chat-input"
            />
            <button type="submit" :disabled="isLoading || !userMessage.trim()" class="send-btn">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.8429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 L4.13399899,1.16151496 C3.34915502,0.9 2.40734225,1.00636533 1.77946707,1.4776575 C0.994623095,2.10604706 0.837654326,3.0486314 1.15159189,3.98722575 L3.03521743,10.4282188 C3.03521743,10.5853161 3.34915502,10.7424135 3.50612381,10.7424135 L16.6915026,11.5279004 C16.6915026,11.5279004 17.1624089,11.5279004 17.1624089,12.0003466 C17.1624089,12.4744748 16.6915026,12.4744748 16.6915026,12.4744748 Z"/>
              </svg>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, nextTick } from 'vue';

export default {
  name: 'ChatBot',
  setup() {
    const isOpen = ref(false);
    const messages = ref([]);
    const userMessage = ref('');
    const isLoading = ref(false);
    const messagesContainer = ref(null);
    const sessionId = ref('');
    const unreadCount = ref(0);
    const showRating = ref(false);
    const rating = ref(0);

    const quickQuestions = [
      '📱 Có sản phẩm gì mới?',
      '💰 Bao nhiêu tiền?',
      '📦 Giao hàng mất bao lâu?',
      '💳 Cách thanh toán?',
    ];

    onMounted(() => {
      // Generate or retrieve session ID
      sessionId.value = localStorage.getItem('chatbot_session_id') || 
                       'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
      localStorage.setItem('chatbot_session_id', sessionId.value);

      // Load chat history
      loadHistory();

      // Greet user
      setTimeout(() => {
        if (messages.value.length === 0) {
          sendGreeting();
        }
      }, 500);
    });

    const openChat = () => {
      isOpen.value = true;
      unreadCount.value = 0;
      nextTick(() => {
        scrollToBottom();
      });
    };

    const closeChat = () => {
      isOpen.value = false;
    };

    const scrollToBottom = () => {
      if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
      }
    };

    const sendMessage = async () => {
      if (!userMessage.value.trim()) return;

      const message = userMessage.value;
      userMessage.value = '';
      isLoading.value = true;

      console.log('Sending message:', message);

      // Add user message to UI
      messages.value.push({
        type: 'user',
        message: message,
        time: new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }),
      });

      try {
        const response = await fetch('/api/chatbot/send', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({
            message: message,
            session_id: sessionId.value,
          }),
        });

        console.log('Response status:', response.status);
        const data = await response.json();
        console.log('Response data:', data);

        if (data.success) {
          // Add bot response with products if available
          const messageObj = {
            type: 'bot',
            message: data.response,
            time: new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }),
            products: data.products || null,
          };
          console.log('Message object:', messageObj);
          console.log('All messages:', messages.value);
          messages.value.push(messageObj);

          // Show rating after some messages
          if (messages.value.length > 8 && !showRating.value) {
            showRating.value = true;
          }
        }
      } catch (error) {
        console.error('Chat error:', error);
        messages.value.push({
          type: 'bot',
          message: '😅 Xin lỗi, có lỗi xảy ra. Vui lòng thử lại!',
          time: new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }),
        });
      }

      isLoading.value = false;
      nextTick(() => {
        scrollToBottom();
      });
    };

    const sendQuickMessage = async (question) => {
      userMessage.value = question;
      await sendMessage();
    };

    const sendGreeting = async () => {
      isLoading.value = true;
      try {
        const response = await fetch('/api/chatbot/send', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({
            message: 'Xin chào',
            session_id: sessionId.value,
          }),
        });

        const data = await response.json();
        if (data.success) {
          messages.value.push({
            type: 'bot',
            message: data.response,
            time: new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }),
            products: data.products || null,
          });
        }
      } catch (error) {
        console.error('Error sending greeting:', error);
      }
      isLoading.value = false;
    };

    const loadHistory = async () => {
      try {
        const response = await fetch(`/api/chatbot/history/${sessionId.value}`);
        const data = await response.json();
        if (data.success && data.messages.length > 0) {
          messages.value = data.messages;
        }
      } catch (error) {
        console.error('Error loading history:', error);
      }
    };

    const rateConversation = async (stars) => {
      try {
        await fetch('/api/chatbot/rate', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({
            session_id: sessionId.value,
            rating: stars,
          }),
        });
        rating.value = stars;
        showRating.value = false;
      } catch (error) {
        console.error('Error rating:', error);
      }
    };

    const formatPrice = (price) => {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0,
      }).format(price).replace('₫', '').trim();
    };

    return {
      isOpen,
      messages,
      userMessage,
      isLoading,
      messagesContainer,
      unreadCount,
      showRating,
      rating,
      quickQuestions,
      openChat,
      closeChat,
      sendMessage,
      sendQuickMessage,
      rateConversation,
      scrollToBottom,
      formatPrice,
    };
  },
};
</script>

<style scoped>
.chatbot-widget {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 9999;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

.chat-button {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
  transition: all 0.3s ease;
  position: relative;
}

.chat-button:hover {
  transform: scale(1.1);
  box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
}

.chat-button svg {
  width: 24px;
  height: 24px;
}

.unread-badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #ef4444;
  color: white;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: bold;
}

.chat-window {
  position: absolute;
  bottom: 80px;
  right: 0;
  width: 400px;
  height: 600px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.16);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.chat-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.chat-header-title h3 {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
}

.status {
  margin: 4px 0 0;
  font-size: 12px;
  opacity: 0.9;
}

.close-btn {
  background: none;
  border: none;
  color: white;
  cursor: pointer;
  padding: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.chat-messages {
  flex: 1;
  overflow-y: auto;
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.welcome-message {
  text-align: center;
  padding: 20px;
}

.welcome-icon {
  font-size: 48px;
  margin-bottom: 12px;
}

.welcome-message h4 {
  margin: 12px 0;
  font-size: 16px;
  color: #1f2937;
}

.welcome-message p {
  margin: 8px 0;
  font-size: 14px;
  color: #6b7280;
  line-height: 1.5;
}

.quick-questions {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-top: 12px;
}

.quick-btn {
  padding: 10px;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  background: white;
  color: #667eea;
  cursor: pointer;
  font-size: 13px;
  transition: all 0.2s ease;
}

.quick-btn:hover {
  background: #f3f4f6;
  border-color: #667eea;
}

.message {
  display: flex;
  margin-bottom: 4px;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.message.user {
  justify-content: flex-end;
}

.message-content {
  max-width: 70%;
  padding: 10px 14px;
  border-radius: 12px;
  word-wrap: break-word;
  font-size: 14px;
  line-height: 1.4;
}

.user .message-content {
  background: #667eea;
  color: white;
  border-bottom-right-radius: 4px;
}

.bot .message-content {
  background: #f3f4f6;
  color: #1f2937;
  border-bottom-left-radius: 4px;
}

.product-cards-container {
  width: 100%;
  text-align: left;
}

.products-header {
  margin: 0 0 12px 0;
  font-size: 14px;
  font-weight: 500;
  color: #1f2937;
}

.product-cards {
  display: grid;
  grid-template-columns: 1fr;
  gap: 10px;
  max-width: 280px;
  background: yellow;
  padding: 10px;
  border: 2px solid red;
}

.product-card {
  display: flex;
  gap: 10px;
  padding: 10px;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  text-decoration: none;
  color: inherit;
  transition: all 0.2s ease;
  cursor: pointer;
}

.product-card:hover {
  border-color: #667eea;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
  transform: translateY(-2px);
}

.product-image {
  position: relative;
  width: 70px;
  height: 70px;
  flex-shrink: 0;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 6px;
  background: #f3f4f6;
}

.discount-badge {
  position: absolute;
  top: -8px;
  right: -8px;
  background: #ef4444;
  color: white;
  font-size: 11px;
  font-weight: 600;
  padding: 3px 6px;
  border-radius: 4px;
}

.product-info {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.product-info h4 {
  margin: 0;
  font-size: 13px;
  font-weight: 600;
  color: #1f2937;
  line-height: 1.3;
  word-break: break-word;
}

.brand {
  margin: 0;
  font-size: 11px;
  color: #6b7280;
}

.price-section {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
}

.original-price {
  text-decoration: line-through;
  color: #9ca3af;
}

.current-price {
  font-weight: 600;
  color: #ef4444;
}

.stock-status {
  font-size: 11px;
  margin-top: 2px;
}

.in-stock {
  color: #16a34a;
}

.out-of-stock {
  color: #dc2626;
}

.action-button {
  margin-top: 4px;
  font-size: 12px;
  color: #667eea;
  font-weight: 500;
  transition: color 0.2s ease;
}

.product-card:hover .action-button {
  color: #764ba2;
}

.message-time {
  display: block;
  margin-top: 4px;
  font-size: 12px;
  opacity: 0.7;
}

.typing-indicator {
  display: flex;
  gap: 4px;
}

.typing-indicator span {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #9ca3af;
  animation: typing 1.4s infinite;
}

.typing-indicator span:nth-child(2) {
  animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
  animation-delay: 0.4s;
}

@keyframes typing {
  0%, 60%, 100% {
    opacity: 0.5;
    transform: translateY(0);
  }
  30% {
    opacity: 1;
    transform: translateY(-10px);
  }
}

.chat-rating {
  padding: 12px 16px;
  border-top: 1px solid #e5e7eb;
  background: #f9fafb;
  text-align: center;
}

.chat-rating p {
  margin: 0 0 8px;
  font-size: 13px;
  color: #6b7280;
}

.rating-stars {
  display: flex;
  justify-content: center;
  gap: 6px;
}

.star {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  opacity: 0.4;
  transition: opacity 0.2s ease;
}

.star:hover,
.star.active {
  opacity: 1;
}

.chat-input-area {
  padding: 12px 16px;
  border-top: 1px solid #e5e7eb;
  background: white;
}

.input-wrapper {
  display: flex;
  gap: 8px;
}

.chat-input {
  flex: 1;
  padding: 10px 14px;
  border: 1px solid #e5e7eb;
  border-radius: 20px;
  font-size: 14px;
  outline: none;
  transition: border-color 0.2s ease;
}

.chat-input:focus {
  border-color: #667eea;
}

.chat-input:disabled {
  background: #f3f4f6;
  cursor: not-allowed;
}

.send-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.send-btn:hover:not(:disabled) {
  transform: scale(1.05);
}

.send-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Mobile responsive */
@media (max-width: 768px) {
  .chat-window {
    width: calc(100vw - 40px);
    height: calc(100vh - 140px);
    bottom: 80px;
    right: 20px;
    left: 20px;
    max-height: 500px;
  }

  .message-content {
    max-width: 85%;
  }
}
</style>
