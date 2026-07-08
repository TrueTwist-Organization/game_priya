<?php

declare(strict_types=1);

function load_games(): array
{
    static $games = null;

    if ($games !== null) {
        return $games;
    }

    $path = ROOT_PATH . '/data/games.json';

    if (!is_file($path)) {
        return [];
    }

    $decoded = json_decode((string) file_get_contents($path), true);

    if (!is_array($decoded)) {
        return [];
    }

    $games = $decoded;

    return $games;
}

function get_game_by_slug(string $slug): ?array
{
    foreach (load_games() as $game) {
        if (($game['slug'] ?? '') === $slug) {
            return $game;
        }
    }

    return null;
}

function get_games_by_slugs(array $slugs): array
{
    $index = [];

    foreach (load_games() as $game) {
        $index[$game['slug'] ?? ''] = $game;
    }

    $result = [];

    foreach ($slugs as $slug) {
        if (isset($index[$slug])) {
            $result[] = $index[$slug];
        }
    }

    return $result;
}

function get_featured_apps(string $slug): array
{
    $game = get_game_by_slug($slug);
    $featuredSlugs = $game['featured_apps'] ?? [];

    if ($featuredSlugs !== []) {
        return get_games_by_slugs($featuredSlugs);
    }

    return get_related_games($slug, 15);
}

function get_related_games(string $slug, int $count = 10): array
{
    $games = load_games();
    $pool = array_values(array_filter(
        $games,
        static fn(array $game): bool => ($game['slug'] ?? '') !== $slug
    ));

    if ($pool === []) {
        return [];
    }

    $offset = abs(crc32($slug)) % max(1, count($pool) - $count + 1);
    $slice = array_slice($pool, $offset, $count);

    if (count($slice) < $count) {
        $slice = array_merge($slice, array_slice($pool, 0, $count - count($slice)));
    }

    return $slice;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function asset_url(string $path): string
{
    return site_url('assets/' . ltrim($path, '/'));
}

function game_image_url(array $game): string
{
    $image = $game['image'] ?? ($game['slug'] . '.png');
    $local = ROOT_PATH . '/assets/images/games/' . $image;

    if (is_file($local)) {
        return asset_url('images/games/' . $image);
    }

    return asset_url('images/games/placeholder.png');
}

function screenshot_url(string $filename): string
{
    $local = ROOT_PATH . '/assets/images/screenshots/' . $filename;

    if (is_file($local)) {
        return asset_url('images/screenshots/' . $filename);
    }

    return '';
}

function render_stars(int $filled, int $total = 5): string
{
    $html = '';

    for ($i = 1; $i <= $total; $i++) {
        $icon = $i <= $filled ? 'rate-yes.svg' : 'rate-no.svg';
        $html .= '<img class="start" src="' . e(asset_url('images/icons/' . $icon)) . '" alt="Rating" />';
    }

    return $html;
}

function game_page_url(string $slug): string
{
    return site_url('explore/game/' . rawurlencode($slug) . '.html');
}

function demo_ads_enabled(): bool
{
    return defined('DEMO_ADS_ENABLED') && DEMO_ADS_ENABLED;
}

function render_demo_banner(string $slot): void
{
    if (!demo_ads_enabled()) {
        return;
    }

    $sizes = [
        'display_1' => '336 × 280 / 728 × 90',
        'display_2' => '336 × 280 / 728 × 90',
        'display_3' => '336 × 280 / 728 × 90',
    ];
    $sizeLabel = $sizes[$slot] ?? '728 × 90';
    ?>
    <div class="ads">
        <span class="ads-prompt">Advertisement</span>
        <div class="demo-ad-slot" id="demo-ad-<?= e($slot) ?>">
            <div class="demo-ad-content">
                <span class="demo-ad-label">Demo Ad</span>
                <strong><?= e($sizeLabel) ?></strong>
                <p>Display Banner · Slot <?= e($slot) ?></p>
            </div>
        </div>
    </div>
    <?php
}
