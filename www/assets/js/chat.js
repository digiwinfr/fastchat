var chat = {
    _getGravatar: function (email) {
        var $gravatar = document.createElement('img');
        $gravatar.src = 'http://www.gravatar.com/avatar/' + md5(email);
        $gravatar.classList.add('gravatar');
        return $gravatar;
    },
    _getMessagesContainer: function () {
        return document.querySelector('#messages');
    },
    _getMessagesList: function () {
        return document.querySelector('#messages > ol');
    },
    _getUsersList: function () {
        return document.querySelector('#users > ul');
    },
    _clearMessages: function () {
        this._getMessagesList().innerHTML = null;
    },
    _clearUsers: function () {
        this._getUsersList().innerHTML = null;
    },
    _scrollIsOnBottom: function () {
        var $messagesContainer = this._getMessagesContainer();
        return $messagesContainer.scrollTop === $messagesContainer.scrollHeight - $messagesContainer.offsetHeight;
    },
    _appendMessage: function ($messages, message) {
        const $message = document.createElement('li');
        const $author = document.createElement('span');
        $author.classList.add('author');
        $author.innerText = message.author.nickname;
        const $date = document.createElement('span');
        $date.classList.add('date');
        $date.innerText = dayjs(message.date).format('DD/MM HH:mm');
        const $content = document.createElement('div');
        $content.classList.add('content');
        $content.innerHTML = message.content.replace(/\n/g, "<br />");
        const $header = document.createElement('div');
        $header.appendChild(this._getGravatar(message.author.email));
        $header.appendChild($author);
        $header.appendChild($date);
        $message.appendChild($header);
        $message.appendChild($content);
        $messages.appendChild($message)
    },
    _appendUser: function ($users, user) {
        const $user = document.createElement('li');
        $user.appendChild(this._getGravatar(user.email));
        const $nickname = document.createElement('span');
        $nickname.classList.add('nickname');
        $nickname.innerText = user.nickname;
        $user.appendChild($nickname);
        $users.appendChild($user)
    },
    _findMessages: function () {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'messages');
        xhr.send(null);
        return xhr;
    },
    refreshMessages: function () {
        var self = this;
        var xhr = this._findMessages();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var scrollIsOnBottom = self._scrollIsOnBottom();
                    var messages = JSON.parse(xhr.responseText);
                    self._clearMessages();
                    var $messages = self._getMessagesList();
                    for (var i = 0; i < messages.length; i++) {
                        var message = messages[i];
                        self._appendMessage($messages, message);
                    }
                    if (scrollIsOnBottom) {
                        self.updateScroll();
                    }
                } else {
                    console.log('Error: ' + xhr.status);
                }
            }
        };
    },
    _findUsers: function () {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'users');
        xhr.send(null);
        return xhr;
    },
    refreshUsers: function () {
        var self = this;
        var xhr = this._findUsers();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var users = JSON.parse(xhr.responseText);
                    self._clearUsers();
                    var $users = self._getUsersList();
                    for (var i = 0; i < users.length; i++) {
                        var user = users[i];
                        self._appendUser($users, user);
                    }
                } else {
                    console.log('Error: ' + xhr.status);
                }
            }
        };
    },
    addMessage: function () {
        var self = this;
        var $content = document.getElementsByName('content')[0];
        var content = $content.value.trim();
        if (content !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'messages');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(encodeURI('content=' + content));
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        $content.value = '';
                        self.refreshMessages();
                        self.focusContentInput();
                    } else {
                        console.log('Error: ' + xhr.status);
                    }
                }
            };
        }
    },
    focusContentInput: function () {
        document.querySelector('#message-form [name=content]').focus();
    },
    updateScroll: function () {
        var $messagesContainer = this._getMessagesContainer();
        $messagesContainer.scrollTop = $messagesContainer.scrollHeight;
    }
};

(function () {

    document.querySelector('#message-form').addEventListener('submit', function (e) {
        e.preventDefault();
        chat.addMessage();
    });
    document.querySelector('#message-form [name=content]').addEventListener('keydown', function (e) {
        if (e.keyCode === 13 && e.ctrlKey) {
            chat.addMessage();
        }
    });
    chat.focusContentInput();

    chat.refreshMessages();
    chat.refreshUsers();
    setInterval(function () {
        chat.refreshMessages()
        chat.refreshUsers();
    }, 1000);
})();

