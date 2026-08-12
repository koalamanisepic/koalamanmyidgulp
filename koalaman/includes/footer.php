</main>

<footer class="site-footer">
  <div class="wrap">
    <span><?= htmlspecialchars($t['footer']['links']) ?></span>
    <span><?= htmlspecialchars($t['footer']['copyright']) ?> <?= MIDDOT ?> <?= date('Y') ?></span>
  </div>
</footer>

<script src="<?= $base ?>assets/js/main.js?v=<?= @filemtime(__DIR__ . '/../assets/js/main.js') ?: time() ?>"></script>
</body>
</html>
