<h1>Welcome to <?php echo $_settings->info('name') ?> - Management Site</h1>
<hr>
<style>
  #site-cover {
    width:100%;
    height:40em;
    object-fit: cover;
    object-position:center center;
  }
</style>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-th-list"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Categories</span>
          <span class="info-box-number">
            <?php 
              $categorys = $conn->query("SELECT * FROM category_list where delete_flag = 0 ")->num_rows;
              echo format_num($categorys);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Clients</span>
          <span class="info-box-number">
            <?php 
              $clients = $conn->query("SELECT * FROM client_list where `delete_flag` = 0")->num_rows;
              echo format_num($clients);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-file-invoice"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Pending Bills</span>
          <span class="info-box-number">
            <?php 
              $billings = $conn->query("SELECT * FROM billing_list where `status` = 0")->num_rows;
              echo format_num($billings);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<hr>
<center>
  <img src="<?= validate_image($_settings->info('cover')) ?>" alt="<?= validate_image($_settings->info('logo')) ?>" id="site-cover" class="img-fluid w-100">
</center>

<!-- Chatbot Interface -->
<style>
.chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
}

.chat-button {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    transition: all 0.3s ease;
    position: relative;
    z-index: 9999;
}

.chat-button:hover {
    transform: scale(1.1);
    background: #0056b3;
}

.chat-window {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 9998;
}

.chat-header {
    background: #007bff;
    color: white;
    padding: 15px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f8f9fa;
}

.chat-input {
    padding: 15px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
    background: white;
}

.chat-input input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.chat-input button {
    padding: 8px 15px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.message {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 15px;
    max-width: 80%;
    word-wrap: break-word;
}

.user-message {
    background: #007bff;
    color: white;
    margin-left: auto;
}

.bot-message {
    background: #e9ecef;
    color: #333;
}

.close-chat {
    cursor: pointer;
    font-size: 20px;
    color: white;
}

.close-chat:hover {
    opacity: 0.8;
}
</style>

<div class="chat-widget">
    <button class="chat-button" onclick="toggleChat()">
        <i class="fas fa-comments"></i>
    </button>
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">
            <span>Chat Support</span>
            <span class="close-chat" onclick="toggleChat()">&times;</span>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                Hello! How can I help you today?
            </div>
        </div>
        <div class="chat-input">
            <input type="text" id="userInput" placeholder="Type your message..." onkeypress="handleKeyPress(event)">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize chat window state
    const chatWindow = document.getElementById('chatWindow');
    chatWindow.style.display = 'none';
});

function toggleChat() {
    const chatWindow = document.getElementById('chatWindow');
    const currentDisplay = chatWindow.style.display;
    chatWindow.style.display = currentDisplay === 'none' || currentDisplay === '' ? 'flex' : 'none';
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

function sendMessage() {
    const userInput = document.getElementById('userInput');
    const message = userInput.value.trim();
    
    if (message) {
        // Add user message
        addMessage(message, 'user');
        userInput.value = '';
        
        // Simulate bot response
        setTimeout(() => {
            const botResponse = getBotResponse(message);
            addMessage(botResponse, 'bot');
        }, 1000);
    }
}

function addMessage(message, sender) {
    const chatMessages = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}-message`;
    messageDiv.textContent = message;
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function getBotResponse(message) {
    const responses = {
        'hello': 'Hi there! How can I assist you today?',
        'help': 'I can help you with billing, client management, and general inquiries. What would you like to know?',
        'billing': 'You can manage bills in the Billing section. Would you like me to guide you there?',
        'clients': 'You can view and manage clients in the Clients section. Need help with anything specific?',
        'category': 'You can manage categories in the Category section. What would you like to know about categories?',
        'pending': 'You can view pending bills in the Billing section. Would you like me to show you how to check them?'
    };
    
    message = message.toLowerCase();
    for (let key in responses) {
        if (message.includes(key)) {
            return responses[key];
        }
    }
    
    return "I'm not sure I understand. Could you please rephrase your question?";
}
</script>
