    <script src="<?= e(asset_url('js/lazyload.js')) ?>"></script>
    <?php require __DIR__ . '/ad-overlays.php'; ?>
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
