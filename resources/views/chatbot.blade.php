@extends('layout')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Chatbot</h4>
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
    </div>
</div>
<script>
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
@endsection
