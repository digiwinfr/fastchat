var chat = {
    _findMessages: function () {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'messages');
        xhr.send(null);
        return xhr;
    },
    _getGravatar: function (email) {
        var $gravatar = document.createElement('img');
        $gravatar.src = 'http://www.gravatar.com/avatar/' + md5(email);
        $gravatar.classList.add('gravatar');
        return $gravatar;
    },
    _getMessagesContainer: function () {
        return document.getElementById('messages');
    },
    _clearMessages: function () {
        this._getMessagesContainer().innerHTML = null;
    },
    _appendMessage: function ($messages, message) {
        const $message = document.createElement('li');
        const $author = document.createElement('span');
        $author.classList.add('author');
        $author.innerText = message.author.nickname;
        const $date = document.createElement('span');
        $date.classList.add('date');
        $date.innerText = dayjs(message.date).format('DD/MM HH:mm');
        const $content = document.createElement('span');
        $content.classList.add('content');
        $content.innerHTML = message.content;
        const $header = document.createElement('div');
        $header.appendChild(this._getGravatar(message.author.email));
        $header.appendChild($author);
        $header.appendChild($date);
        $message.appendChild($header);
        $message.appendChild($content);
        $messages.appendChild($message)
    },
    refreshMessages: function () {
        var self = this;
        var xhr = this._findMessages();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var messages = JSON.parse(xhr.responseText);
                    self._clearMessages();
                    var $messages = self._getMessagesContainer();
                    for (var i = 0; i < messages.length; i++) {
                        var message = messages[i];
                        self._appendMessage($messages, message);
                    }

                } else {
                    console.log('Error: ' + xhr.status);
                }
            }
        };
    }
};

chat.refreshMessages();
setInterval(function () {
    chat.refreshMessages()
}, 1000);