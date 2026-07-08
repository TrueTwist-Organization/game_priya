(function () {
    var content = document.getElementById('main-screenshots-content');
    var leftBtn = document.getElementById('main-screenshots-left');
    var rightBtn = document.getElementById('main-screenshots-right');

    if (!content || !leftBtn || !rightBtn) {
        return;
    }

    function updateButtons() {
        leftBtn.classList.toggle('disabled', content.scrollLeft <= 0);
        rightBtn.classList.toggle('disabled', content.scrollLeft + content.clientWidth >= content.scrollWidth - 5);
    }

    leftBtn.addEventListener('click', function () {
        content.scrollBy({ left: -content.clientWidth * 0.8, behavior: 'smooth' });
        setTimeout(updateButtons, 300);
    });

    rightBtn.addEventListener('click', function () {
        content.scrollBy({ left: content.clientWidth * 0.8, behavior: 'smooth' });
        setTimeout(updateButtons, 300);
    });

    content.addEventListener('scroll', debounce(updateButtons, 100));
    updateButtons();
})();

function openDownload(url) {
    if (!url) {
        return;
    }

    window.open(url, '_blank', 'noopener,noreferrer');
}

function debounce(fn, wait) {
    var timer = null;
    return function () {
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(fn, wait);
    };
}
