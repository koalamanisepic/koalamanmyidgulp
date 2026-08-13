</main>

<footer class="site-footer">
  <div class="wrap">
    <span><?= htmlspecialchars($t['footer']['links']) ?></span>
    <span><?= htmlspecialchars($t['footer']['copyright']) ?> <?= MIDDOT ?> <?= date('Y') ?></span>
  </div>
</footer>

<button type="button" class="clown-mascot" id="clown-mascot" aria-label="<?= htmlspecialchars($t['mascot']['aria_label']) ?>">
  <img src="<?= $base ?>assets/img/clown-avatar.png" alt="" width="386" height="390" loading="lazy">
</button>
<audio id="clown-audio" src="<?= $base ?>assets/audio/clown-nose-squeak.mp3" preload="auto"></audio>

<script src="<?= $base ?>assets/js/main.js?v=<?= @filemtime(__DIR__ . '/../assets/js/main.js') ?: time() ?>"></script>
</body>
</html>
