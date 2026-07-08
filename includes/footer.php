    <footer>
        <div class="line"></div>
        <div class="footer-content" style="max-width: 1030px">
            <p style="font-size: 16px; margin-bottom: 30px">
                Welcome to <?= e(SITE_NAME) ?>, here we have the best games including
                strategy games, RPG games, horror games, simulation games, shooting
                games, casual games and many more kinds of games. We offer free game
                apk to download. Discover the best games and download faster, easier and
                safer.
            </p>
            <p style="text-align: left;">Disclaimer<br><br>
                1. Independent Platform<br>
                <?= e(SITE_NAME) ?> is an independent content platform and does not develop, own, or publish any of
                the games or applications featured on this website. We are not affiliated with or endorsed by any official game
                developers or publishers unless explicitly stated.<br>
                2. Content Source &amp; Purpose<br>
                All game-related information, including descriptions, screenshots, APK references, and historical
                versions, is collected from publicly available sources such as official app stores (e.g., Google Play Store and Apple
                App Store). This content is provided strictly for informational and discovery purposes to help users explore
                games.<br>
                3. Intellectual Property Rights<br>
                All trademarks, logos, product names, and brand assets displayed on this website belong to their
                respective owners. We do not claim ownership of any third-party intellectual property.<br>
                4. Download &amp; External Links<br>
                We do not host or modify any copyrighted APK files on our servers unless explicitly stated. Where
                applicable, we provide official download links directing users to trusted platforms such as the Google Play Store or
                App Store. Users are encouraged to download applications only from official sources.<br>
                5. User Responsibility<br>
                Users are solely responsible for how they use the information and links provided on this website. We do
                not guarantee compatibility, safety, or performance of third-party applications.<br>
                6. Contact Information<br>
                For any inquiries, copyright concerns, or content removal requests, please contact us via the official
                contact page.
            </p><br>
            <div class="links">
                <a href="<?= e(site_url('explore/contact.html')) ?>" title="Contact">Contact</a>
                <a href="<?= e(site_url('explore/privacy.html')) ?>" title="Privacy">Privacy Policy</a>
                <a href="<?= e(site_url('explore/terms.html')) ?>" title="Terms">Terms Of Services</a>
            </div>
            <p class="introduce">&copy; <?= e(SITE_NAME) ?></p>
        </div>
    </footer>
    <?php require __DIR__ . '/ad-overlays.php'; ?>
    <script src="<?= e(asset_url('js/lazyload.js')) ?>"></script>
    <?php if (demo_ads_enabled()): ?>
        <script src="<?= e(asset_url('js/demo-ads.js')) ?>"></script>
    <?php endif; ?>
    <?php if (!empty($extraJs)): ?>
        <?php foreach ($extraJs as $js): ?>
            <script src="<?= e(asset_url('js/' . $js)) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
