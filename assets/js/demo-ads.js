(function () {
    'use strict';

    var interShown = false;
    var pageType = document.body.getAttribute('data-ad-page') || 'home';
    var REWARDED_DURATION = 5;
    var REWARDED_LOAD_DELAY = 2000;
    var HOME_IDLE_TIMEOUT = 150000;
    var rewardedTimerId = null;
    var homeIdleTimer = null;
    var homeIdleReady = false;

    function qs(sel) {
        return document.querySelector(sel);
    }

    function showInterstitialOnce(callback) {
        if (interShown) {
            if (callback) {
                callback();
            }
            return;
        }

        interShown = true;
        var overlay = qs('#demo-interstitial');

        if (!overlay) {
            if (callback) {
                setTimeout(callback, 700);
            }
            return;
        }

        overlay.classList.add('is-visible');

        function closeInterstitial() {
            overlay.classList.remove('is-visible');
            if (callback) {
                callback();
            }
        }

        var closeBtn = overlay.querySelector('.demo-interstitial-close');
        if (closeBtn) {
            closeBtn.onclick = closeInterstitial;
        }

        setTimeout(closeInterstitial, 700);
    }

    window.showInterstitialOnce = showInterstitialOnce;

    window.showInterstitial = function (callback) {
        showInterstitialOnce(callback);
    };

    function showDemoRewardedAd(onClose) {
        var overlay = qs('#demo-rewarded-ad');
        if (!overlay) {
            if (onClose) {
                onClose();
            }
            return;
        }

        if (rewardedTimerId) {
            clearInterval(rewardedTimerId);
            rewardedTimerId = null;
        }

        var countdownEl = qs('#demo-reward-countdown');
        var progressBar = qs('#demo-rewarded-progress');
        var closeBtn = qs('#demo-rewarded-close');
        var remaining = REWARDED_DURATION;

        overlay.classList.add('is-visible');
        overlay.setAttribute('aria-hidden', 'false');

        if (countdownEl) {
            countdownEl.textContent = String(remaining);
        }
        if (progressBar) {
            progressBar.style.width = '0%';
        }
        if (closeBtn) {
            closeBtn.disabled = true;
            closeBtn.classList.remove('is-ready');
            closeBtn.textContent = 'Close Ad';
        }

        function finishRewardedAd() {
            if (rewardedTimerId) {
                clearInterval(rewardedTimerId);
                rewardedTimerId = null;
            }
            overlay.classList.remove('is-visible');
            overlay.setAttribute('aria-hidden', 'true');
            if (onClose) {
                onClose();
            }
        }

        if (closeBtn) {
            closeBtn.onclick = function () {
                if (!closeBtn.disabled) {
                    finishRewardedAd();
                }
            };
        }

        rewardedTimerId = setInterval(function () {
            remaining -= 1;

            if (countdownEl) {
                countdownEl.textContent = String(Math.max(remaining, 0));
            }
            if (progressBar) {
                var pct = ((REWARDED_DURATION - remaining) / REWARDED_DURATION) * 100;
                progressBar.style.width = Math.min(pct, 100) + '%';
            }

            if (remaining <= 0) {
                clearInterval(rewardedTimerId);
                rewardedTimerId = null;
                if (closeBtn) {
                    closeBtn.disabled = false;
                    closeBtn.classList.add('is-ready');
                    closeBtn.textContent = 'Close Ad ✓ Reward Earned';
                }
                if (progressBar) {
                    progressBar.style.width = '100%';
                }
            }
        }, 1000);
    }

    window.showDemoRewardedAd = showDemoRewardedAd;

    function scheduleRewardedAd() {
        setTimeout(function () {
            showDemoRewardedAd();
        }, REWARDED_LOAD_DELAY);
    }

    function initRewardedAdOnLoad() {
        if (pageType !== 'detail') {
            return;
        }

        scheduleRewardedAd();
    }

    function initRewardedAdOnBack() {
        if (pageType !== 'detail') {
            return;
        }

        window.addEventListener('pageshow', function (event) {
            if (!event.persisted) {
                return;
            }

            var overlay = qs('#demo-rewarded-ad');
            if (overlay) {
                overlay.classList.remove('is-visible');
                overlay.setAttribute('aria-hidden', 'true');
            }

            scheduleRewardedAd();
        });
    }

    function resetHomeIdleTimer() {
        homeIdleReady = false;

        if (homeIdleTimer) {
            clearTimeout(homeIdleTimer);
            homeIdleTimer = null;
        }

        homeIdleTimer = setTimeout(function () {
            homeIdleReady = true;
        }, HOME_IDLE_TIMEOUT);
    }

    function initHomeIdleRewardedAd() {
        if (pageType !== 'home' || !qs('#demo-rewarded-ad')) {
            return;
        }

        function onHomeActivity() {
            if (homeIdleReady) {
                homeIdleReady = false;

                var overlay = qs('#demo-rewarded-ad');
                if (overlay && !overlay.classList.contains('is-visible')) {
                    showDemoRewardedAd();
                }
            }

            resetHomeIdleTimer();
        }

        resetHomeIdleTimer();

        ['scroll', 'wheel', 'touchstart', 'mousemove', 'keydown', 'click'].forEach(function (eventName) {
            window.addEventListener(eventName, onHomeActivity, { passive: true });
        });
    }

    function initFirstClickInterstitial() {
        document.addEventListener(
            'click',
            function () {
                showInterstitialOnce();
            },
            { once: true }
        );
    }

    function initAnchorAd() {
        var anchor = qs('#demo-anchor-ad');
        if (!anchor) {
            return;
        }

        var grippy = anchor.querySelector('.demo-anchor-grippy');
        var collapsed = false;

        function setAnchorPosition() {
            if (document.body.clientWidth <= 500) {
                anchor.classList.add('demo-anchor-ad--top');
                anchor.classList.remove('demo-anchor-ad--bottom');
            } else {
                anchor.classList.add('demo-anchor-ad--bottom');
                anchor.classList.remove('demo-anchor-ad--top');
            }
        }

        function setCollapsed(nextCollapsed) {
            collapsed = nextCollapsed;
            anchor.classList.toggle('is-collapsed', collapsed);

            if (grippy) {
                grippy.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
                grippy.setAttribute(
                    'aria-label',
                    collapsed ? 'Expand advertisement' : 'Collapse advertisement'
                );
            }
        }

        if (grippy) {
            grippy.addEventListener('click', function () {
                setCollapsed(!collapsed);
            });
        }

        setAnchorPosition();

        setTimeout(function () {
            anchor.classList.add('is-visible');
            anchor.setAttribute('aria-hidden', 'false');
        }, 1200);

        window.addEventListener('resize', setAnchorPosition);
    }

    function initPageLoader() {
        var loader = qs('#page-loader');
        if (!loader) {
            return;
        }

        window.addEventListener('load', function () {
            setTimeout(function () {
                loader.style.display = 'none';
            }, 800);
        });
    }

    window.reward = function (event, url, type) {
        if (event) {
            event.preventDefault();
        }

        var bodyLoading = qs('.body-loading');
        if (!bodyLoading) {
            window.open(url, '_blank', 'noopener,noreferrer');
            return;
        }

        var rewardedOverlay = qs('#demo-rewarded-ad');
        if (rewardedOverlay) {
            rewardedOverlay.classList.remove('is-visible');
            rewardedOverlay.setAttribute('aria-hidden', 'true');
        }

        bodyLoading.style.display = 'flex';

        var spinner = bodyLoading.querySelector('.loader');
        if (spinner) {
            spinner.style.display = 'block';
        }

        var tooltip = bodyLoading.querySelector('.tooltip');
        if (tooltip) {
            tooltip.style.display = 'none';
        }

        setTimeout(function () {
            showTip(url, type);
        }, 5000);
    };

    function showTip(url, type) {
        var bodyLoading = qs('.body-loading');
        if (!bodyLoading) {
            return;
        }

        var spinner = bodyLoading.querySelector('.loader');
        if (spinner) {
            spinner.style.display = 'none';
        }

        var tooltip = bodyLoading.querySelector('.tooltip');
        if (tooltip) {
            tooltip.style.display = 'block';
        }

        var storeName = type === 'apple' ? 'App Store' : 'Google Play';
        var span = qs('.tooltip .tooltip-text p span');
        if (span) {
            span.textContent = storeName;
        }

        var continueBtn = qs('.tooltip-button-continue');
        if (continueBtn) {
            continueBtn.href = url;
            continueBtn.onclick = function () {
                bodyLoading.style.display = 'none';
            };
        }

        var cancelBtn = qs('.tooltip-button-cancel');
        if (cancelBtn) {
            cancelBtn.onclick = function () {
                bodyLoading.style.display = 'none';
                window.location.reload();
            };
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initFirstClickInterstitial();

        if (pageType === 'detail') {
            initPageLoader();
            initAnchorAd();
            initRewardedAdOnLoad();
            initRewardedAdOnBack();
        }

        if (pageType === 'home') {
            initHomeIdleRewardedAd();
        }
    });
})();
