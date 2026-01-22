<!-- BEGIN: main -->
<div class="chat-container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-robot"></i> {LANG.ai_counselor}</h3>
        </div>
        <div class="panel-body" id="chat-history" style="height: 400px; overflow-y: scroll; padding: 15px;">
            <!-- BEGIN: message_loop -->
            <div class="message {MSG.sender_class}">
                <div class="message-content">
                    <strong>{MSG.sender_name}:</strong> {MSG.message}
                </div>
            </div>
            <!-- END: message_loop -->
        </div>
        <div class="panel-footer">
            <div class="input-group">
                <input type="text" id="chat-input" class="form-control" placeholder="{LANG.type_message}..." />
                <span class="input-group-btn">
                    <button class="btn btn-primary" id="btn-send" type="button">{LANG.send}</button>
                </span>
            </div>
        </div>
    </div>
</div>

<style>
    .message { margin-bottom: 10px; }
    .message.user { text-align: right; }
    .message.ai { text-align: left; }
    .message.user .message-content { background-color: #dcf8c6; display: inline-block; padding: 8px 12px; border-radius: 15px; }
    .message.ai .message-content { background-color: #f1f0f0; display: inline-block; padding: 8px 12px; border-radius: 15px; }
</style>

<script>
    var session_token = '{SESSION_TOKEN}';
    var ajax_url = '{AJAX_URL}';

    $('#btn-send').click(function() {
        sendMessage();
    });

    $('#chat-input').keypress(function(e) {
        if(e.which == 13) {
            sendMessage();
        }
    });

    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    function sendMessage() {
        var message = $('#chat-input').val().trim();
        if (message == '') return;

        var safeMessage = escapeHtml(message);

        $('#chat-history').append('<div class="message user"><div class="message-content"><strong>{LANG.you}:</strong> ' + safeMessage + '</div></div>');
        $('#chat-input').val('');
        scrollToBottom();

        $.ajax({
            type: 'POST',
            url: ajax_url,
            data: {
                ajax_action: 'send_message',
                message: message,
                session_token: session_token
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    // AI response is trusted from server (sanitized there or safe by AI nature), but for extra safety we could escape too.
                    // However, AI might return Markdown/Formatting. For now, assuming text.
                    // Let's treat AI response as text but allow simple formatting if we parsed it.
                    // Given the simple requirement, escaping it is safer or using .text() method.
                    // Since we are appending HTML string, we must be careful.
                    // Let's assume AI returns plain text for this simple implementation.
                    var safeReply = escapeHtml(response.reply);
                    $('#chat-history').append('<div class="message ai"><div class="message-content"><strong>AI:</strong> ' + safeReply + '</div></div>');
                    session_token = response.session_token;
                    scrollToBottom();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Connection error');
            }
        });
    }

    function scrollToBottom() {
        var chatHistory = document.getElementById("chat-history");
        chatHistory.scrollTop = chatHistory.scrollHeight;
    }
</script>
<!-- END: main -->
