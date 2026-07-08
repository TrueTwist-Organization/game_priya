<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
$game = $slug !== '' ? get_game_by_slug($slug) : null;

if ($game === null) {
    http_response_code(404);
    echo 'Game not found';
    exit;
}

$title = $game['title'] ?? 'Game';
$pageTitle = 'Get ' . $title . ' for Free | ' . SITE_NAME;
$pageDescription = $game['meta_description'] ?? ('Download ' . $title . ' for free on Android and iOS.');
$cssFile = 'detail.css';
$extraJs = ['detail.js'];
$adPageType = 'detail';

$stars = (int) ($game['stars'] ?? 4);
$ratingScore = $game['rating_score'] ?? '4.5';
$category = $game['category'] ?? 'Games';
$age = $game['age'] ?? '4+';
$table = $game['info_table'] ?? [];
$histogram = $game['histogram'] ?? ['70%', '15%', '8%', '4%', '3%'];
$screenshots = $game['screenshots'] ?? [];
$related = get_related_games($slug, 10);
$featuredApps = get_featured_apps($slug);
$googleUrl = $game['downloads']['google'] ?? '';
$appleUrl = $game['downloads']['apple'] ?? '';

require dirname(__DIR__) . '/includes/header.php';
?>

<div class="detail-main-container">
    <div class="main-container">
        <div class="detail-info-main-cointainer">
            <div class="info-card">
                <div class="info-img relative">
                    <img class="lazy-load cover-img" data-load="<?= e(game_image_url($game)) ?>" alt="<?= e($title) ?>" />
                    <div class="loader"></div>
                </div>
                <div class="info-info">
                    <div class="info-name">
                        <h1><?= e($title) ?></h1>
                    </div>
                    <div class="info-developer pc">
                        <div class="info-downloads info-developer-item">
                            <img class="icon" src="<?= e(asset_url('images/icons/category.svg')) ?>" alt="category" />
                            <div class="number"><?= e($category) ?></div>
                        </div>
                        <div class="line"></div>
                        <div class="info-size info-developer-item">
                            <img class="icon" src="<?= e(asset_url('images/icons/age.svg')) ?>" alt="age" />
                            <div class="number"><?= e($age) ?></div>
                        </div>
                    </div>
                    <div class="info-rating">
                        <div class="rating-container">
                            <?= render_stars($stars) ?>
                            <span class="rating-score"><?= e($ratingScore) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <?php render_demo_banner('display_2'); ?>

            <div class="about-game">
                <ul class="game-info-table">
                    <li class="phone">
                        <span class="info-key">Category</span><span class="info-value"><?= e($category) ?></span>
                    </li>
                    <li><span class="info-key">Platform</span><span class="info-value"><?= e($table['Platform'] ?? 'Android') ?></span></li>
                    <li class="phone">
                        <span class="info-key">Age</span><span class="info-value"><?= e($age) ?></span>
                    </li>
                    <li><span class="info-key">Price</span><span class="info-value"><?= e($table['Price'] ?? 'Free') ?></span></li>
                    <li><span class="info-key">Installs</span><span class="info-value"><?= e($table['Installs'] ?? '1 Million+') ?></span></li>
                    <li><span class="info-key">Updated</span><span class="info-value"><?= e($table['Updated'] ?? date('Y-m-d')) ?></span></li>
                    <li><span class="info-key">Size</span><span class="info-value"><?= e($table['Size'] ?? '100 M+') ?></span></li>
                </ul>
            </div>

            <?php render_demo_banner('display_3'); ?>

            <?php if (!empty($game['description'])): ?>
                <div class="editor-review">
                    <div class="editor-review-title"><span>Editor's Review</span></div>
                    <div class="desc"><span><?= e($game['description']) ?></span></div>
                </div>
            <?php endif; ?>

            <?php if (!empty($game['how_to_play'])): ?>
                <div class="how-to-play">
                    <div class="how-to-play-title"><span>How To Play?</span></div>
                    <div class="how-to-play-info">
                        <?php foreach ($game['how_to_play'] as $line): ?>
                            <p><?= e($line) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php render_demo_banner('display_1'); ?>

            <div class="download-link">
                <div class="get-the-game-down">
                    <?php if ($appleUrl !== ''): ?>
                        <div class="down-link-item t-play" onclick="reward(event,'<?= e($appleUrl) ?>','apple')">
                            <span>App Store</span>
                        </div>
                    <?php else: ?>
                        <div class="down-link-item gray down-link-item-ban"><span>App Store</span></div>
                    <?php endif; ?>

                    <?php if ($googleUrl !== ''): ?>
                        <div class="down-link-item t-play" onclick="reward(event,'<?= e($googleUrl) ?>','google')">
                            <span>Google Play</span>
                        </div>
                    <?php else: ?>
                        <div class="down-link-item gray down-link-item-ban"><span>Google Play</span></div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($screenshots !== []): ?>
                <div class="screenshots">
                    <div class="screenshots-title"><span>Screenshots</span></div>
                    <div class="main-screenshots">
                        <div class="disabled" id="main-screenshots-left"></div>
                        <div id="main-screenshots-right"></div>
                        <div id="main-screenshots-content">
                            <div class="main-screenshots-sub-container visible-horizontal" id="screenshots_container">
                                <?php foreach ($screenshots as $shot): ?>
                                    <?php $shotUrl = screenshot_url($shot); ?>
                                    <?php if ($shotUrl === '') { continue; } ?>
                                    <div class="main-screenshots-item border-radius shadow relative">
                                        <img class="main-screenshots-img lazy-load cs-lazy" data-load="<?= e($shotUrl) ?>" alt="<?= e($title) ?>" />
                                        <div class="loader"></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="rating-histogram">
                <div class="rating-histogram-title"><span>Ratings</span></div>
                <div class="rating-box-container">
                    <div class="rating-info">
                        <span><?= e($ratingScore) ?></span>
                        <div class="rating-container"><?= render_stars($stars) ?></div>
                    </div>
                    <div class="histogram-info">
                        <ul class="rating-detail">
                            <?php foreach ([5, 4, 3, 2, 1] as $i => $star): ?>
                                <li>
                                    <span><?= $star ?></span>
                                    <p class="score-progress"><b style="--width: <?= e($histogram[$i] ?? '0%') ?>"></b></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="rec-game">
                <div class="rec-game-title">Featured App</div>
                <div class="rec-game-container">
                    <div class="game-list">
                        <?php foreach ($featuredApps as $item): ?>
                            <a class="game-item t-image" href="<?= e(game_page_url($item['slug'])) ?>" title="<?= e($item['title']) ?>">
                                <div class="item-img relative">
                                    <img class="game-item-img lazy-load" data-load="<?= e(game_image_url($item)) ?>" alt="<?= e($item['title']) ?>" />
                                    <div class="loader"></div>
                                </div>
                                <div class="item-info">
                                    <h2><?= e($item['title']) ?></h2>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-rec-container">
        <div class="you-may-like">
            <div class="you-may-like-title">Top Games</div>
            <div class="game-list">
                <?php foreach ($related as $item): ?>
                    <a class="game-item" href="<?= e(game_page_url($item['slug'])) ?>" title="<?= e($item['title']) ?>">
                        <img class="item-img lazy-load" data-load="<?= e(game_image_url($item)) ?>" alt="<?= e($item['title']) ?>" />
                        <div class="item-info">
                            <h2><?= e($item['title']) ?></h2>
                            <span><?= e($item['category'] ?? 'Games') ?></span>
                            <div class="rating-container">
                                <?= render_stars((int) ($item['stars'] ?? 4)) ?>
                                <span class="rating-score"><?= e($item['rating_score'] ?? '4.5') ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
