<?php
require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/papers-store.php';

$canonicalPath = 'papers/';
$p = $t['papers'];

$errors = [];
$justAdded = isset($_GET['added']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim((string) ($_POST['title'] ?? ''));
    $description = trim((string) ($_POST['description'] ?? ''));
    $writtenAt = trim((string) ($_POST['written_at'] ?? ''));
    $passphrase = (string) ($_POST['passphrase'] ?? '');
    $file = $_FILES['file'] ?? null;

    if ($title === '') {
        $errors[] = $p['error_empty'];
    }
    if (!hash_equals(CONTENT_PASSPHRASE, $passphrase)) {
        $errors[] = $p['error_passphrase'];
    }

    if (!$errors) {
        $uploadError = papers_handle_upload($file ?? [], $title, $description, $writtenAt);
        if ($uploadError !== null) {
            $errors[] = $p[$uploadError] ?? $p['error_upload_failed'];
        }
    }

    if (!$errors) {
        header('Location: ' . with_lang('.', $lang) . '&added=1');
        exit;
    }
}

require __DIR__ . '/../includes/header.php';

$papers = array_reverse(papers_index_read());

function papers_format_date(string $iso, string $lang): string
{
    $ts = strtotime($iso) ?: time();
    if ($lang === 'fr') {
        $months = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
        return (int) date('j', $ts) . ' ' . $months[(int) date('n', $ts) - 1] . ' ' . date('Y', $ts);
    }
    return date('j F Y', $ts);
}

function papers_format_size(int $bytes): string
{
    if ($bytes >= 1024 * 1024) {
        return round($bytes / (1024 * 1024), 1) . ' MB';
    }
    return round($bytes / 1024) . ' KB';
}
?>

<section class="section section--tight">
  <div class="wrap" style="max-width: 760px;">

    <a class="back-link" href="<?= htmlspecialchars(with_lang('../index.php', $lang)) ?>#papers">
      ← <?= htmlspecialchars($p['back']) ?>
    </a>

    <div class="subpage-head">
      <p class="subpage-eyebrow"><?= htmlspecialchars($p['eyebrow']) ?></p>
      <h1 class="subpage-title"><?= htmlspecialchars($p['title']) ?></h1>
      <p class="subpage-desc"><?= htmlspecialchars($p['desc']) ?></p>
    </div>

    <?php if ($errors): ?>
      <div class="form-message form-message--error" style="margin-top:2rem;">
        <?php foreach ($errors as $error): ?>
          <div><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
      </div>
    <?php elseif ($justAdded): ?>
      <div class="form-message form-message--success" style="margin-top:2rem;">
        <?= htmlspecialchars($p['success']) ?>
      </div>
    <?php endif; ?>

    <form class="french-form" method="post" action="<?= htmlspecialchars(with_lang('.', $lang)) ?>" enctype="multipart/form-data">
      <p class="form-title"><?= htmlspecialchars($p['form_title']) ?></p>

      <div class="form-group">
        <label class="form-label" for="title"><?= htmlspecialchars($p['label_title']) ?></label>
        <input class="form-input" type="text" id="title" name="title" placeholder="<?= htmlspecialchars($p['placeholder_title']) ?>" required value="<?= isset($title) && $errors ? htmlspecialchars($title) : '' ?>">
      </div>

      <div class="form-group">
        <label class="form-label" for="description"><?= htmlspecialchars($p['label_description']) ?></label>
        <input class="form-input" type="text" id="description" name="description" placeholder="<?= htmlspecialchars($p['placeholder_description']) ?>" value="<?= isset($description) && $errors ? htmlspecialchars($description) : '' ?>">
      </div>

      <div class="form-group">
        <label class="form-label" for="written_at"><?= htmlspecialchars($p['label_date']) ?></label>
        <input class="form-input" type="date" id="written_at" name="written_at" max="<?= date('Y-m-d') ?>" value="<?= isset($writtenAt) && $errors ? htmlspecialchars($writtenAt) : '' ?>">
      </div>

      <div class="form-group">
        <label class="form-label" for="file"><?= htmlspecialchars($p['label_file']) ?></label>
        <input class="form-input" type="file" id="file" name="file" accept="application/pdf" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="passphrase"><?= htmlspecialchars($p['label_passphrase']) ?></label>
        <input class="form-input" type="password" id="passphrase" name="passphrase" placeholder="<?= htmlspecialchars($p['placeholder_passphrase']) ?>" required>
      </div>

      <div class="form-hint">
        <button class="btn btn-primary" type="submit" style="margin-top:0;">
          <?= htmlspecialchars($p['submit']) ?>
        </button>
      </div>
    </form>

    <div class="log-wall">
      <p class="log-wall-title"><?= htmlspecialchars($p['list_title']) ?> <?= MIDDOT ?> <?= count($papers) ?></p>

      <?php if (!$papers): ?>
        <p class="log-empty"><?= htmlspecialchars($p['list_empty']) ?></p>
      <?php else: ?>
        <?php foreach ($papers as $entry): ?>
          <?php $writtenDate = $entry['written_at'] ?? ''; ?>
          <article class="log-entry">
            <p class="log-entry-sentence"><?= htmlspecialchars($entry['title']) ?></p>
            <?php if (!empty($entry['description'])): ?>
              <p class="log-entry-note"><?= htmlspecialchars($entry['description']) ?></p>
            <?php endif; ?>
            <?php if ($writtenDate !== ''): ?>
              <p class="log-entry-date">
                <?= htmlspecialchars($p['written_prefix']) ?> <?= htmlspecialchars(papers_format_date($writtenDate, $lang)) ?>
              </p>
            <?php endif; ?>
            <p class="log-entry-date" style="<?= $writtenDate !== '' ? 'opacity:0.75; margin-top:0.15rem;' : '' ?>">
              <?= htmlspecialchars($p['uploaded_prefix']) ?> <?= htmlspecialchars(papers_format_date($entry['uploaded_at'], $lang)) ?>
              <?= MIDDOT ?> <?= htmlspecialchars(papers_format_size((int) $entry['size'])) ?>
            </p>
            <a class="card-link" href="<?= htmlspecialchars('download.php?id=' . urlencode($entry['id'])) ?>" target="_blank" rel="noopener" style="margin-top:0.75rem;">
              <?= htmlspecialchars($p['view']) ?>
              <span class="btn-arrow" aria-hidden="true">→</span>
            </a>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
