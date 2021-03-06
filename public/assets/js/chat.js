var chat = {
    _lastMessageId: null,
    _getGravatar: function (user) {
        var $gravatar = document.createElement('img');
        if (user.bot) {
            $gravatar.src = 'assets/images/robot.png';
        } else {
            $gravatar.src = 'http://www.gravatar.com/avatar/' + md5(user.email) + '?d=identicon';
        }
        $gravatar.classList.add('gravatar');
        return $gravatar;
    },
    _getMessagesContainer: function () {
        return document.querySelector('#left-panel');
    },
    _getMessagesList: function () {
        return document.querySelector('#messages');
    },
    _getUsersList: function () {
        return document.querySelector('#users');
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
        var md = window.markdownit({
            breaks: true,
            linkify: true
        });
        md.use(window.markdownitEmoji);
        var content = md.render(message.content);
        $content.innerHTML = content;
        const $header = document.createElement('div');
        $header.appendChild(this._getGravatar(message.author));
        $header.appendChild($author);
        $header.appendChild($date);
        $message.appendChild($header);
        $message.appendChild($content);
        $messages.appendChild($message)
    },
    _appendUser: function ($users, user) {
        const $user = document.createElement('li');
        if (!user.connected) {
            $user.classList.add('disconnected');
        }
        $user.appendChild(this._getGravatar(user));
        const $nickname = document.createElement('span');
        $nickname.classList.add('nickname');
        $nickname.innerText = user.nickname;
        $user.appendChild($nickname);
        const $email = document.createElement('span');
        $email.classList.add('email');
        $email.innerText = '<' + user.email + '>';
        $user.appendChild($email);
        $users.appendChild($user)
    },
    _findMessages: function () {
        var xhr = new XMLHttpRequest();
        var url;
        if (this._lastMessageId == null) {
            url = 'messages';
        } else {
            url = 'messages/from/' + this._lastMessageId
        }
        xhr.open('GET', url);
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
                    if (messages.length > 0) {
                        var lastMessageId = messages[messages.length - 1].id;
                        if (self._lastMessageId != lastMessageId) {
                            self._lastMessageId = lastMessageId;
                            var $messages = self._getMessagesList();
                            for (var i = 0; i < messages.length; i++) {
                                var message = messages[i];
                                self._appendMessage($messages, message);
                            }
                            if (scrollIsOnBottom) {
                                self.updateScroll();
                            }
                        }
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
                    var usersTotal = 0;
                    var connectedUsers = 0;
                    for (var i = 0; i < users.length; i++) {
                        var user = users[i];
                        connectedUsers += user.connected ? 1 : 0;
                        usersTotal = i;
                        self._appendUser($users, user);
                    }
                    self._refreshUsersCounter(connectedUsers, usersTotal);
                } else {
                    console.log('Error: ' + xhr.status);
                }
            }
        };
    },
    _refreshUsersCounter: function (connectedUsers, usersTotal) {
        document.querySelector('#users-counter .col').innerText = connectedUsers + ' connectés / ' + usersTotal;
    },
    addMessage: function () {
        var self = this;
        var $content = document.getElementsByName('content')[0];
        var content = $content.value;
        if (content.trim() !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'messages');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('content=' + encodeURIComponent(content));
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        $content.value = '';
                        self.refreshMessages();
                    } else {
                        console.log('Error: ' + xhr.status);
                    }
                }
            };
        }
        self.focusContentInput();
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

