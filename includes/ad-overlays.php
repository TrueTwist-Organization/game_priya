<?php

declare(strict_types=1);

if (!demo_ads_enabled()) {
    return;
}

$adPageType = $adPageType ?? 'home';
?>

<div id="demo-interstitial" class="demo-interstitial" aria-hidden="true">
    <div class="demo-interstitial-box">
        <button type="button" class="demo-interstitial-close" aria-label="Close">&times;</button>
        <span class="ads-prompt">Advertisement</span>
        <div class="demo-interstitial-inner">
            <strong>Interstitial Ad</strong>
            <span>Demo · Full Screen · 700ms</span>
        </div>
    </div>
</div>

<?php if ($adPageType === 'detail'): ?>
    <div id="page-loader">
        <div class="spinner"></div>
        <div class="loader-text">Loading...</div>
    </div>

    <div id="demo-anchor-ad" class="demo-anchor-ad demo-anchor-ad--bottom">
        <span class="ads-prompt">Advertisement</span>
        <div class="demo-anchor-inner">
            Anchor Ad (Demo)
            <small>320 × 50 · Bottom / Top on mobile</small>
        </div>
    </div>

    <div class="body-loading">
        <div class="loader"></div>
        <div class="tooltip">
            <div class="tooltip-text">
                <p>Coming soon to the <span>App Store</span></p>
                <p>Are you sure you want to continue?</p>
            </div>
            <div class="tooltip-button">
                <div class="tooltip-button-cancel">CANCEL</div>
                <a class="tooltip-button-continue" target="_blank" rel="noopener noreferrer">CONTINUE</a>
            </div>
        </div>
    </div>

    <div id="demo-rewarded-ad" class="demo-rewarded-ad" aria-hidden="true">
        <div class="demo-rewarded-content">
            <span class="ads-prompt">Advertisement · Rewarded</span>
            <div class="demo-rewarded-video">
                <div class="demo-rewarded-video-inner">
                    <div class="demo-rewarded-icon">▶</div>
                    <strong>Rewarded Video Ad</strong>
                    <span>Demo · Rewarded Slot</span>
                </div>
                <div class="demo-rewarded-progress">
                    <div class="demo-rewarded-progress-bar" id="demo-rewarded-progress"></div>
                </div>
                <p class="demo-rewarded-timer">Reward in <span id="demo-reward-countdown">5</span>s</p>
            </div>
            <button type="button" class="demo-rewarded-close" id="demo-rewarded-close" disabled>Close Ad</button>
        </div>
    </div>
<?php endif; ?>
