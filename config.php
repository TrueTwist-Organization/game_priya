<?php

declare(strict_types=1);

define('SITE_NAME', 'PlayVerse Hub');
define('SITE_TAGLINE', 'Play & Download Top Free Mobile Games');
define('SITE_EMAIL', 'contact@example.com');
define('ROOT_PATH', __DIR__);
define('BASE_URL', '');
define('DEMO_ADS_ENABLED', true);

function site_url(string $path = ''): string
{
    $base = rtrim(BASE_URL, '/');
    $path = ltrim($path, '/');

    if ($path === '') {
        return $base === '' ? '/' : $base . '/';
    }

    return ($base === '' ? '' : $base) . '/' . $path;
}
