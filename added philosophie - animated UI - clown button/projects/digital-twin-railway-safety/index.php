<?php
require __DIR__ . '/../../includes/bootstrap.php';
$canonicalPath = 'projects/digital-twin-railway-safety/';
require __DIR__ . '/../../includes/header.php';

$p = $t['projects']['featured'];
?>

<section class="section section--tight">
  <div class="wrap" style="max-width: 760px;">
    <p class="section-label"><?= htmlspecialchars($p['code']) ?></p>
    <h1 class="section-title" style="font-size: clamp(1.9rem, 4vw, 2.6rem);"><?= htmlspecialchars($p['name']) ?></h1>
    <p class="section-desc" style="max-width: 60ch; margin-top: 1rem;"><?= htmlspecialchars($p['desc']) ?></p>

    <div class="tag-list" style="margin-top: 1.5rem;">
      <?php foreach ($p['tags'] as $tag): ?>
        <span class="tag"><?= htmlspecialchars($tag) ?></span>
      <?php endforeach; ?>
    </div>

    <hr style="border: none; border-top: 1px solid var(--border); margin: 2.5rem 0;">

    <p class="card-desc">
      <?= $lang === 'fr'
          ? 'La documentation détaillée de ce projet (schémas, code, journal de bord, résultats) sera ajoutée ici.'
          : 'Detailed documentation for this project (diagrams, code, build log, results) will be added here.' ?>
    </p>
  </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
