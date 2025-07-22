<!-- Floating Chatbot Widget -->
<style>
#chatbot-icon {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
    background: #007bff;
    color: #fff;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
#chatbot-panel {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 350px;
    max-width: 95vw;
    z-index: 9999;
    display: none;
}
#chatbot-panel .card {
    box-shadow: 0 2px 16px rgba(0,0,0,0.2);
}
#chatbot-close {
    position: absolute;
    top: 8px;
    right: 12px;
    background: none;
    border: none;
    font-size: 20px;
    color: #888;
    cursor: pointer;
}
</style>
<div id="chatbot-icon" title="Chat với Fresh Fruit!">
    💬
</div>
<div id="chatbot-panel">
    <div class="card">
        <div class="card-header bg-primary text-white text-center" style="position:relative;">
            <h5 style="margin:0;">Chatbot</h5>
            <button id="chatbot-close" title="Đóng">&times;</button>
        </div>
        <div class="card-body">
            <div id="messages" style="height:300px;overflow-y:auto;border:1px solid #ccc;padding:10px;margin-bottom:10px;"></div>
            <form id="chat-form">
                <div class="input-group">
                    <input type="text" id="user-input" autocomplete="off" class="form-control" placeholder="Type your message..." required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('chatbot-icon').onclick = function() {
    document.getElementById('chatbot-panel').style.display = 'block';
    document.getElementById('chatbot-icon').style.display = 'none';
};
document.getElementById('chatbot-close').onclick = function() {
    document.getElementById('chatbot-panel').style.display = 'none';
    document.getElementById('chatbot-icon').style.display = 'flex';
};
document.getElementById('chat-form').onsubmit = async function(e) {
    e.preventDefault();
    let input = document.getElementById('user-input');
    let msg = input.value;
    let messages = document.getElementById('messages');
    messages.innerHTML += '<div><b>You:</b> ' + msg + '</div>';
    input.value = '';
    let res = await fetch('/chatbot/message', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: JSON.stringify({message: msg})
    });
    let data = await res.json();
    messages.innerHTML += '<div><b>Bot:</b> ' + data.reply + '</div>';
    messages.scrollTop = messages.scrollHeight;
};
</script>
