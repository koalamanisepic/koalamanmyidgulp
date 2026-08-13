<?php
require __DIR__ . '/includes/bootstrap.php';
$canonicalPath = '';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="wrap hero-grid">

    <div class="hero-main">
      <h1 class="visually-hidden"><?= htmlspecialchars($t['meta']['title']) ?></h1>
      <p class="hero-volume"><?= htmlspecialchars($t['hero']['volume']) ?></p>
      <a class="btn btn-primary" href="#learning">
        <?= htmlspecialchars($t['hero']['cta']) ?>
        <span class="btn-arrow" aria-hidden="true">→</span>
      </a>
    </div>

    <nav class="hero-index" aria-label="<?= htmlspecialchars($t['hero']['contents']) ?>">
      <p class="hero-index-label"><?= htmlspecialchars($t['hero']['contents']) ?></p>
      <ol>
        <li>
          <a href="#learning">
            <span class="index-num">01</span>
            <span class="index-name"><?= htmlspecialchars($t['learning']['label']) ?></span>
            <span class="index-count"><?= count($t['learning']['items']) ?> <?= htmlspecialchars($t['learning']['unit']) ?></span>
          </a>
        </li>
        <li>
          <a href="#projects">
            <span class="index-num">02</span>
            <span class="index-name"><?= htmlspecialchars($t['projects']['label']) ?></span>
            <span class="index-count">1 <?= htmlspecialchars($t['projects']['unit']) ?></span>
          </a>
        </li>
      </ol>
    </nav>

  </div>
</section>

<!-- Learning ================================================== -->
<section class="section reveal" id="learning">
  <div class="wrap">
    <div class="section-head">
      <div>
        <span class="section-label"><?= htmlspecialchars($t['learning']['label']) ?></span>
        <h2 class="section-title"><?= htmlspecialchars($t['learning']['title']) ?></h2>
      </div>
      <p class="section-desc"><?= htmlspecialchars($t['learning']['desc']) ?></p>
    </div>

    <div class="grid grid--auto">
      <?php foreach ($t['learning']['items'] as $item): ?>
        <article class="card">
          <span class="card-code"><?= htmlspecialchars($item['code']) ?></span>
          <h3 class="card-title"><?= htmlspecialchars($item['name']) ?></h3>
          <p class="card-desc"><?= htmlspecialchars($item['desc']) ?></p>
          <a class="card-link" href="<?= htmlspecialchars(with_lang($item['link'], $lang)) ?>">
            <?= htmlspecialchars($t['learning']['cta']) ?>
            <span class="btn-arrow" aria-hidden="true">→</span>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Projects =================================================== -->
<section class="section reveal" id="projects">
  <div class="wrap">
    <div class="section-head">
      <div>
        <span class="section-label"><?= htmlspecialchars($t['projects']['label']) ?></span>
        <h2 class="section-title"><?= htmlspecialchars($t['projects']['title']) ?></h2>
      </div>
      <p class="section-desc"><?= htmlspecialchars($t['projects']['desc']) ?></p>
    </div>

    <?php $p = $t['projects']['featured']; ?>
    <article class="card card--featured">
      <div>
        <span class="card-code"><?= htmlspecialchars($p['code']) ?></span>
        <h3 class="card-title" style="font-size:1.4rem; margin-top:0.6rem;"><?= htmlspecialchars($p['name']) ?></h3>
        <p class="card-desc" style="margin-top:0.75rem;"><?= htmlspecialchars($p['desc']) ?></p>
        <a class="card-link" href="<?= htmlspecialchars(with_lang($p['link'], $lang)) ?>" style="margin-top:1.25rem;">
          <?= htmlspecialchars($t['projects']['cta']) ?>
          <span class="btn-arrow" aria-hidden="true">→</span>
        </a>
      </div>
      <div>
        <div class="tag-list">
          <?php foreach ($p['tags'] as $tag): ?>
            <span class="tag"><?= htmlspecialchars($tag) ?></span>
          <?php endforeach; ?>
        </div>
      </div>
    </article>
  </div>
</section>

<!-- Hardware controllers ======================================= -->
<section class="esp32-section reveal">
  <div class="wrap">
    <div class="esp32-head">
      <p class="esp32-label"><?= htmlspecialchars($t['esp32']['label']) ?></p>
      <h2 class="esp32-title"><?= htmlspecialchars($t['esp32']['title']) ?></h2>
      <p class="esp32-desc"><?= htmlspecialchars($t['esp32']['desc']) ?></p>
    </div>

    <div class="grid grid--2 esp32-grid">
      <?php foreach ($t['esp32']['items'] as $device): ?>
        <div class="esp32-panel">
          <div class="esp32-panel-text">
            <h3 class="esp32-device-name"><?= htmlspecialchars($device['name']) ?></h3>
            <p class="esp32-device-desc"><?= htmlspecialchars($device['desc']) ?></p>
          </div>
          <a class="btn btn-outline" href="<?= htmlspecialchars($device['link']) ?>">
            <?= htmlspecialchars($t['esp32']['cta']) ?>
            <span class="btn-arrow" aria-hidden="true">→</span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
