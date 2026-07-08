<?php

declare(strict_types=1);

$pageTitle = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? SITE_TAGLINE;
$extraCss = $extraCss ?? [];
$bodyClass = $bodyClass ?? '';
$adPageType = $adPageType ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="yes" name="apple-touch-fullscreen" />
    <meta content="telephone=no,email=no" name="format-detection" />
    <meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>" />
    <meta name="keywords" content="Top Free Games for Phones, Popular Game Downloads, Action-Packed Mobile Titles, Strategic Gameplay Apps, Brain Teaser Games, High-Speed Racing Apps, Games for Kids and Teens" />
    <link rel="stylesheet" href="<?= e(asset_url('css/' . ($cssFile ?? 'home.css'))) ?>" />
    <?php if (demo_ads_enabled()): ?>
        <link rel="stylesheet" href="<?= e(asset_url('css/ads.css')) ?>" />
    <?php endif; ?>
    <?php foreach ($extraCss as $css): ?>
        <link rel="stylesheet" href="<?= e(asset_url('css/' . $css)) ?>" />
    <?php endforeach; ?>
    <?php if (($cssFile ?? '') === 'detail.css'): ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Noto+Sans:wght@400;600;700&display=swap" rel="stylesheet">
        <meta name="theme-color" content="#0BCBFF" />
    <?php endif; ?>
</head>
<body class="<?= e($bodyClass) ?>" data-ad-page="<?= e($adPageType) ?>">
