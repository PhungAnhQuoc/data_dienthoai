<!-- ChatBot Widget - Vanilla JavaScript -->
<div id="chatbot-floating-btn" class="chatbot-btn">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
    </svg>
</div>

<div id="chatbot-window" class="chatbot-window" style="display: none;">
    <div class="chatbot-header">
        <h3>💬 Mobile Shop Chat</h3>
        <button id="chatbot-close" class="chatbot-close">&times;</button>
    </div>
    <div class="chatbot-messages" id="chatbot-messages">
        <div class="chatbot-welcome">
            <p>👋 Xin chào! Tôi là bot tư vấn. Hỏi tôi về sản phẩm!</p>
        </div>
    </div>
    <div class="chatbot-input-area">
        <input type="text" id="chatbot-input" class="chatbot-input" placeholder="Gõ tin nhắn...">
        <button id="chatbot-send" class="chatbot-send">Gửi</button>
    </div>
</div>

<style>
.chatbot-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
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
    z-index: 9999;
    transition: all 0.3s ease;
}

.chatbot-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
}

.chatbot-window {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 400px;
    height: 600px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.16);
    display: flex;
    flex-direction: column;
    z-index: 9998;
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

.chatbot-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-header h3 {
    margin: 0;
    font-size: 16px;
}

.chatbot-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.chatbot-welcome {
    text-align: center;
    padding: 20px;
    color: #666;
}

.chatbot-message {
    display: flex;
    margin-bottom: 4px;
}

.chatbot-message.user {
    justify-content: flex-end;
}

.chatbot-message-content {
    max-width: 70%;
    padding: 10px 14px;
    border-radius: 12px;
    word-wrap: break-word;
    font-size: 14px;
    line-height: 1.4;
}

.chatbot-message.user .chatbot-message-content {
    background: #667eea;
    color: white;
    border-bottom-right-radius: 4px;
}

.chatbot-message.bot .chatbot-message-content {
    background: #f3f4f6;
    color: #1f2937;
    border-bottom-left-radius: 4px;
}

.chatbot-input-area {
    padding: 12px 16px;
    border-top: 1px solid #e5e7eb;
    background: white;
    display: flex;
    gap: 8px;
}

.chatbot-input {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    font-size: 14px;
    outline: none;
}

.chatbot-input:focus {
    border-color: #667eea;
}

.chatbot-send {
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

.chatbot-send:hover {
    transform: scale(1.05);
}

.chatbot-send:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .chatbot-window {
        width: calc(100vw - 40px);
        height: calc(100vh - 140px);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('chatbot-floating-btn');
    const window = document.getElementById('chatbot-window');
    const closeBtn = document.getElementById('chatbot-close');
    const input = document.getElementById('chatbot-input');
    const sendBtn = document.getElementById('chatbot-send');
    const messagesDiv = document.getElementById('chatbot-messages');

    // Open/close chatbot
    btn.addEventListener('click', () => {
        window.style.display = window.style.display === 'none' ? 'flex' : 'none';
    });

    closeBtn.addEventListener('click', () => {
        window.style.display = 'none';
    });

    // Send message
    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    function sendMessage() {
        const message = input.value.trim();
        if (!message) return;

        // Add user message
        addMessage(message, 'user');
        input.value = '';
        sendBtn.disabled = true;

        // Get session ID
        let sessionId = localStorage.getItem('chatbot_session_id');
        if (!sessionId) {
            sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('chatbot_session_id', sessionId);
        }

        // Call backend API
        fetch('/api/chatbot/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                message: message,
                session_id: sessionId,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addMessage(data.response, 'bot');
            } else {
                addMessage('Xin lỗi, không thể xử lý. Vui lòng thử lại!', 'bot');
            }
            sendBtn.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            addMessage('Lỗi kết nối. Vui lòng thử lại!', 'bot');
            sendBtn.disabled = false;
        });
    }

    function addMessage(text, type) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `chatbot-message ${type}`;
        msgDiv.innerHTML = `<div class="chatbot-message-content">${escapeHtml(text)}</div>`;
        messagesDiv.appendChild(msgDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function getBotResponse(message) {
        const msg = message.toLowerCase();
        
        if (msg.includes('xin chào') || msg.includes('hi') || msg.includes('hello')) {
            return 'Chào bạn! 👋 Tôi có thể giúp bạn tìm sản phẩm, hỏi về giá, giao hàng hay thanh toán. Hỏi tôi gì đi!';
        } else if (msg.includes('sản phẩm') || msg.includes('iphone') || msg.includes('điện thoại')) {
            return 'Chúng tôi có nhiều điện thoại hay: iPhone 15, Samsung Galaxy S24, OnePlus 12... Bạn quan tâm loại nào?';
        } else if (msg.includes('giá') || msg.includes('bao nhiêu')) {
            return 'Có nhiều sản phẩm đang khuyến mãi! iPhone giảm 15%, Samsung giảm 20%. Bạn muốn biết sản phẩm cụ thể nào?';
        } else if (msg.includes('giao hàng') || msg.includes('vận chuyển')) {
            return 'Giao hàng chuẩn: 3-5 ngày (miễn phí), giao nhanh: 1-2 ngày (50k), siêu tốc: hôm nay (100k). Chọn kiểu nào?';
        } else if (msg.includes('thanh toán') || msg.includes('trả tiền')) {
            return 'Chúng tôi hỗ trợ: COD, chuyển khoản, thẻ tín dụng, Momo, ZaloPay. Cách nào bạn thích?';
        } else {
            return 'Tôi có thể giúp về sản phẩm, giá cả, giao hàng, thanh toán hoặc bảo hành. Hỏi cái gì?';
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>
<?php /**PATH C:\xampp\htdocs\mobile-shop-master\resources\views/partials/chatbot-widget.blade.php ENDPATH**/ ?>