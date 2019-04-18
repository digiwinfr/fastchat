(function () {
    var md = window.markdownit({
        breaks: true,
        linkify: true
    });
    md.use(window.markdownitEmoji);

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/assets/help.md');
    xhr.send(null);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var help = md.render(xhr.responseText);
                document.getElementById('help').innerHTML = help;
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };

})();