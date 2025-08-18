<!-- Floating Chat Button -->
<div id="chatbot-floating-btn" class="chatbot-floating-btn">
   <div class="chat-icon">
      <i class="bi bi-chat-dots"></i>
   </div>
   <div class="chat-tooltip">Hỗ trợ</div>
</div>

<!-- Chatbot Modal -->
<div id="chatbot-modal" class="chatbot-modal">
   <div class="chatbot-container">
      <div class="chatbot-header">
         <div class="chatbot-title">
            <i class="bi bi-robot"></i>
            <span>AI Tư Vấn HTAutoStore</span>
         </div>
         <div class="chatbot-controls">
            <button id="minimize-btn" class="control-btn" title="Thu nhỏ">
               <i class="bi bi-dash"></i>
            </button>
            <button id="close-btn" class="control-btn" title="Đóng">
               <i class="bi bi-x"></i>
            </button>
         </div>
      </div>

      <div class="chatbot-messages" id="chatbot-messages">
         <div class="welcome-message">
            <div class="bot-avatar">
               <i class="bi bi-robot"></i>
            </div>
            <div class="message-content">
               <div class="message-text">
                  Xin chào! Tôi là AI trợ lý của HTAutoStore. Tôi có thể giúp bạn:
                  <br>• Tư vấn sản phẩm công nghệ
                  <br>• Tư vấn phụ kiện ô tô
                  <br>• Giải đáp thắc mắc
                  <br><br>Bạn cần hỗ trợ gì hôm nay?
               </div>
            </div>
         </div>
      </div>

      <div class="typing-indicator" id="typing-indicator" style="display: none;">
         <div class="bot-avatar">
            <i class="bi bi-robot"></i>
         </div>
         <div class="typing-dots">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
         </div>
      </div>
      <!-- send tin nhan tu nguoi dung  -->
      <div class="chatbot-input">
         <form id="chatbot-form">
            <div class="input-container">
               <input type="text" id="chatbot-input" placeholder="Nhập câu hỏi của bạn..." autocomplete="off">
               <button type="submit" id="send-btn">
                  <i class="bi bi-send"></i>
               </button>
            </div>
         </form>
      </div>
   </div>
</div>

<style>
   /* Floating Button Styles */
   .chatbot-floating-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
      transition: all 0.3s ease;
      z-index: 1000;
      animation: pulse 2s infinite;
   }

   .chatbot-floating-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
   }

   .chatbot-floating-btn .chat-icon {
      color: white;
      font-size: 24px;
      transition: transform 0.3s ease;
   }

   .chatbot-floating-btn:hover .chat-icon {
      transform: scale(1.1);
   }

   .chat-tooltip {
      position: absolute;
      right: 70px;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.8);
      color: white;
      padding: 8px 12px;
      border-radius: 6px;
      font-size: 12px;
      white-space: nowrap;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
   }

   .chatbot-floating-btn:hover .chat-tooltip {
      opacity: 1;
      visibility: visible;
      right: 75px;
   }

   .chat-tooltip::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 100%;
      transform: translateY(-50%);
      border: 5px solid transparent;
      border-left-color: rgba(0, 0, 0, 0.8);
   }

   /* Modal Styles */
   .chatbot-modal {
      position: fixed;
      bottom: 100px;
      right: 30px;
      width: 380px;
      height: 500px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 40px rgba(0, 0, 0, 0.15);
      z-index: 1001;
      display: none;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
      animation: slideUp 0.3s ease-out;
   }

   .chatbot-modal.show {
      display: flex;
      flex-direction: column;
   }

   .chatbot-modal.minimized {
      height: 60px;
      overflow: hidden;
   }

   .chatbot-container {
      display: flex;
      flex-direction: column;
      height: 100%;
   }

   .chatbot-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 16px 20px;
      border-radius: 16px 16px 0 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
   }

   .chatbot-title {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      font-size: 16px;
   }

   .chatbot-controls {
      display: flex;
      gap: 8px;
   }

   .control-btn {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      width: 28px;
      height: 28px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.2s;
   }

   .control-btn:hover {
      background: rgba(255, 255, 255, 0.3);
   }

   .chatbot-messages {
      flex: 1;
      overflow-y: auto;
      padding: 20px;
      background: #f8fafc;
      background-image:
         radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.05) 0%, transparent 50%),
         radial-gradient(circle at 80% 20%, rgba(120, 119, 198, 0.05) 0%, transparent 50%);
   }

   .welcome-message,
   .chat-message {
      display: flex;
      gap: 10px;
      margin-bottom: 16px;
      animation: fadeIn 0.3s ease-in;
   }

   .chat-message.user {
      flex-direction: row-reverse;
   }

   .bot-avatar,
   .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 14px;
      color: white;
   }

   .bot-avatar {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
   }

   .user-avatar {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
   }

   .message-content {
      max-width: 75%;
      background: white;
      padding: 12px 16px;
      border-radius: 18px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      border: 1px solid #e5e7eb;
   }

   .chat-message.user .message-content {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
   }

   .message-text {
      font-size: 14px;
      line-height: 1.5;
      word-wrap: break-word;
   }

   .message-time {
      font-size: 11px;
      opacity: 0.7;
      margin-top: 6px;
      text-align: right;
   }

   .chat-message.user .message-time {
      text-align: left;
   }

   .typing-indicator {
      display: flex;
      gap: 10px;
      margin-bottom: 16px;
   }

   .typing-dots {
      background: white;
      padding: 12px 16px;
      border-radius: 18px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      border: 1px solid #e5e7eb;
      display: flex;
      gap: 4px;
   }

   .typing-dot {
      width: 6px;
      height: 6px;
      background: #9ca3af;
      border-radius: 50%;
      animation: typing 1.4s infinite ease-in-out;
   }

   .typing-dot:nth-child(1) {
      animation-delay: -0.32s;
   }

   .typing-dot:nth-child(2) {
      animation-delay: -0.16s;
   }

   .chatbot-input {
      padding: 16px 20px;
      background: white;
      border-radius: 0 0 16px 16px;
      border-top: 1px solid #e5e7eb;
   }

   .input-container {
      display: flex;
      gap: 8px;
      align-items: center;
   }

   #chatbot-input {
      flex: 1;
      border: 2px solid #e5e7eb;
      border-radius: 20px;
      padding: 10px 16px;
      font-size: 14px;
      outline: none;
      transition: border-color 0.2s;
   }

   #chatbot-input:focus {
      border-color: #667eea;
   }

   #send-btn {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      color: white;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: transform 0.2s;
   }

   #send-btn:hover {
      transform: scale(1.05);
   }

   #send-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
   }

   /* Animations */
   @keyframes pulse {

      0%,
      100% {
         box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
      }

      50% {
         box-shadow: 0 4px 20px rgba(102, 126, 234, 0.8);
      }
   }

   @keyframes slideUp {
      from {
         opacity: 0;
         transform: translateY(20px);
      }

      to {
         opacity: 1;
         transform: translateY(0);
      }
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

   @keyframes typing {

      0%,
      80%,
      100% {
         transform: scale(0.8);
         opacity: 0.5;
      }

      40% {
         transform: scale(1);
         opacity: 1;
      }
   }

   /* Scrollbar */
   .chatbot-messages::-webkit-scrollbar {
      width: 4px;
   }

   .chatbot-messages::-webkit-scrollbar-track {
      background: #f1f5f9;
   }

   .chatbot-messages::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 2px;
   }

   /* Responsive */
   @media (max-width: 768px) {
      .chatbot-modal {
         width: calc(100vw - 40px);
         right: 20px;
         left: 20px;
         bottom: 100px;
      }

      .chatbot-floating-btn {
         bottom: 20px;
         right: 20px;
         width: 50px;
         height: 50px;
      }

      .chatbot-floating-btn .chat-icon {
         font-size: 20px;
      }
   }
</style>

<script>
   document.addEventListener('DOMContentLoaded', function() {
      const floatingBtn = document.getElementById('chatbot-floating-btn');
      const modal = document.getElementById('chatbot-modal');
      const closeBtn = document.getElementById('close-btn');
      const minimizeBtn = document.getElementById('minimize-btn');
      const form = document.getElementById('chatbot-form');
      const input = document.getElementById('chatbot-input');
      const sendBtn = document.getElementById('send-btn');
      const messagesContainer = document.getElementById('chatbot-messages');
      const typingIndicator = document.getElementById('typing-indicator');

      let isMinimized = false;

      // Toggle modal
      floatingBtn.addEventListener('click', function() {
         modal.classList.toggle('show');
         if (modal.classList.contains('show')) {
            input.focus();
         }
      });

      // Close modal
      closeBtn.addEventListener('click', function() {
         modal.classList.remove('show');
         isMinimized = false;
         modal.classList.remove('minimized');
      });

      // Minimize/maximize modal
      minimizeBtn.addEventListener('click', function() {
         isMinimized = !isMinimized;
         modal.classList.toggle('minimized', isMinimized);

         if (isMinimized) {
            minimizeBtn.innerHTML = '<i class="bi bi-window"></i>';
            minimizeBtn.title = 'Mở rộng';
         } else {
            minimizeBtn.innerHTML = '<i class="bi bi-dash"></i>';
            minimizeBtn.title = 'Thu nhỏ';
            input.focus();
         }
      });

      // goi tin nhan
      form.addEventListener('submit', async function(e) {
         e.preventDefault();

         const message = input.value.trim();
         if (!message) return;

         addMessage(message, 'user');
         input.value = '';

         input.disabled = true;
         sendBtn.disabled = true;

         // Show typing
         showTyping();

         try {
            const response = await fetch('/chatbot/send', {
               method: 'POST',
               headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
               },
               body: JSON.stringify({
                  message: message
               })
            });

            const data = await response.json();
            hideTyping();

            if (data.success) {
               addMessage(data.message, 'bot');
            } else {
               addMessage('Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau.', 'bot');
            }
         } catch (error) {
            hideTyping();
            addMessage('Không thể kết nối đến server. Vui lòng thử lại.', 'bot');
         }

         // Enable input
         input.disabled = false;
         sendBtn.disabled = false;
         input.focus();
      });

      function addMessage(text, sender) {
         const messageDiv = document.createElement('div');
         messageDiv.className = `chat-message ${sender}`;

         const avatar = document.createElement('div');
         avatar.className = sender === 'user' ? 'user-avatar' : 'bot-avatar';
         avatar.innerHTML = sender === 'user' ? '<i class="bi bi-person"></i>' : '<i class="bi bi-robot"></i>';

         const content = document.createElement('div');
         content.className = 'message-content';
         content.innerHTML = `
            <div class="message-text">${text}</div>
            <div class="message-time">${new Date().toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'})}</div>
        `;

         messageDiv.appendChild(avatar);
         messageDiv.appendChild(content);
         messagesContainer.appendChild(messageDiv);

         scrollToBottom();
      }

      function showTyping() {
         typingIndicator.style.display = 'flex';
         scrollToBottom();
      }

      function hideTyping() {
         typingIndicator.style.display = 'none';
      }

      function scrollToBottom() {
         setTimeout(() => {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
         }, 100);
      }

      // Enter to send
      input.addEventListener('keypress', function(e) {
         if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
         }
      });

      // Close modal when clicking outside
      document.addEventListener('click', function(e) {
         if (!modal.contains(e.target) && !floatingBtn.contains(e.target)) {
            // Uncomment if you want to close when clicking outside
            // modal.classList.remove('show');
         }
      });
   });
</script>