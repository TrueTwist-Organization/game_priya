<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = SITE_TAGLINE . ' | ' . SITE_NAME;
$pageDescription = 'Play and download the best free mobile games! Enjoy action, racing, puzzle, cooking games, and more—fun for all ages and interests.';
$cssFile = 'home.css';
$adPageType = 'home';
$games = load_games();

require __DIR__ . '/includes/header.php';
?>

<main class="index-content">
    <section>
        <div class="grid-warp">
            <div class="game-list-warp">
                <ul class="game-list">
                    <?php foreach ($games as $game): ?>
                        <li>
                            <a class="game-link" href="<?= e(game_page_url($game['slug'])) ?>" title="<?= e($game['title']) ?>">
                                <div class="relative" style="width: 100%; height: 100%">
                                    <img
                                        class="game-img lazy-load"
                                        alt="<?= e($game['title']) ?>"
                                        data-load="<?= e(game_image_url($game)) ?>"
                                    />
                                    <h2 class="game-item-title"><?= e($game['title']) ?></h2>
                                    <div class="game-item-shadow"></div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
