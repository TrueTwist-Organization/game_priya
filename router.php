<?php

declare(strict_types=1);

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$file = __DIR__ . $uri;

if ($uri !== '/' && is_file($file)) {
    return false;
}

if (preg_match('#^/explore/game/([^/]+)\.html$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/explore/game.php';
    return true;
}

if ($uri === '/explore/contact.html') {
    require __DIR__ . '/explore/contact.php';
    return true;
}

if ($uri === '/explore/privacy.html') {
    require __DIR__ . '/explore/privacy.php';
    return true;
}

if ($uri === '/explore/terms.html') {
    require __DIR__ . '/explore/terms.php';
    return true;
}

require __DIR__ . '/index.php';
return true;
