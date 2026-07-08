<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

$pageTitle = 'Contact Us | ' . SITE_NAME;
$pageDescription = 'Contact ' . SITE_NAME;
$cssFile = 'pages.css';
$bodyClass = 'page-static';
$adPageType = 'static';

require dirname(__DIR__) . '/includes/header.php';
?>

<h1>Contact Us</h1>
<p>Got a question or want to share your thoughts? We'd love to hear from you!</p>
<p>Drop us a line at <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a> and we'll get back to you as soon as we can.</p>
<p>Your feedback helps make our game portal even better. Thanks for being part of our community!</p>
<a href="<?= e(site_url()) ?>" class="btn-home">Back to Home</a>

<?php require dirname(__DIR__) . '/includes/footer-min.php'; ?>
