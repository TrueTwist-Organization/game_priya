var viewHeight = document.documentElement.clientHeight;

function debounce(fn, wait) {
    var timer = null;
    return function () {
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(fn, wait);
    };
}

function lazyLoadImgs() {
    var imgs = document.querySelectorAll('img[data-load]');
    imgs.forEach(function (img) {
        var rect = img.parentElement.getBoundingClientRect();
        var visible = rect.bottom >= 0 && rect.top < viewHeight;

        if (!visible || img.dataset.loaded) {
            return;
        }

        img.onload = function () {
            this.style.display = 'block';
            var loaders = this.parentElement.getElementsByClassName('loader');
            if (loaders[0]) {
                loaders[0].style.display = 'none';
            }
        };

        img.setAttribute('src', img.dataset.load);
        img.setAttribute('data-loaded', 'true');
    });
}

lazyLoadImgs();
document.addEventListener('scroll', debounce(lazyLoadImgs, 100));
document.addEventListener('resize', debounce(function () {
    viewHeight = document.documentElement.clientHeight;
    lazyLoadImgs();
}, 200));
