<?php
require __DIR__ . '/../../includes/bootstrap.php';
require __DIR__ . '/../../includes/config.php';
require __DIR__ . '/../../includes/french-log.php';

$canonicalPath = 'learning/french/';
$f = $t['french'];

$errors = [];
$justAdded = isset($_GET['added']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sentence   = trim((string) ($_POST['sentence'] ?? ''));
    $note       = trim((string) ($_POST['note'] ?? ''));
    $passphrase = (string) ($_POST['passphrase'] ?? '');

    if ($sentence === '') {
        $errors[] = $f['error_empty'];
    }
    if (!hash_equals(FRENCH_LOG_PASSPHRASE, $passphrase)) {
        $errors[] = $f['error_passphrase'];
    }

    if (!$errors) {
        french_log_add($sentence, $note);
        // Redirect so a page refresh never resubmits the form.
        header('Location: ' . with_lang('.', $lang) . '&added=1');
        exit;
    }
}

require __DIR__ . '/../../includes/header.php';

$entries = array_reverse(french_log_read());

// Locale-aware date formatting per language, no external dependency.
function french_log_format_date(string $iso, string $lang): string
{
    $ts = strtotime($iso) ?: time();
    if ($lang === 'fr') {
        $months = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
        return (int) date('j', $ts) . ' ' . $months[(int) date('n', $ts) - 1] . ' ' . date('Y', $ts);
    }
    return date('j F Y', $ts);
}
?>

<section class="section section--tight">
  <div class="wrap" style="max-width: 760px;">

    <a class="back-link" href="<?= htmlspecialchars(with_lang('../../index.php', $lang)) ?>#learning">
      ← <?= htmlspecialchars($f['back']) ?>
    </a>

    <div class="subpage-head">
      <p class="subpage-eyebrow"><?= htmlspecialchars($f['eyebrow']) ?></p>
      <h1 class="subpage-title"><?= htmlspecialchars($f['title']) ?></h1>
      <p class="subpage-desc"><?= htmlspecialchars($f['desc']) ?></p>
    </div>

    <?php if ($errors): ?>
      <div class="form-message form-message--error" style="margin-top:2rem;">
        <?php foreach ($errors as $error): ?>
          <div><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
      </div>
    <?php elseif ($justAdded): ?>
      <div class="form-message form-message--success" style="margin-top:2rem;">
        <?= htmlspecialchars($f['success']) ?>
      </div>
    <?php endif; ?>

    <form class="french-form" method="post" action="<?= htmlspecialchars(with_lang('.', $lang)) ?>">
      <p class="form-title"><?= htmlspecialchars($f['form_title']) ?></p>

      <div class="form-group">
        <label class="form-label" for="sentence"><?= htmlspecialchars($f['label_sentence']) ?></label>
        <textarea class="form-textarea" id="sentence" name="sentence" placeholder="<?= htmlspecialchars($f['placeholder_sentence']) ?>" required><?= isset($sentence) && $errors ? htmlspecialchars($sentence) : '' ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="note"><?= htmlspecialchars($f['label_note']) ?></label>
        <input class="form-input" type="text" id="note" name="note" placeholder="<?= htmlspecialchars($f['placeholder_note']) ?>" value="<?= isset($note) && $errors ? htmlspecialchars($note) : '' ?>">
      </div>

      <div class="form-group">
        <label class="form-label" for="passphrase"><?= htmlspecialchars($f['label_passphrase']) ?></label>
        <input class="form-input" type="password" id="passphrase" name="passphrase" placeholder="<?= htmlspecialchars($f['placeholder_passphrase']) ?>" required>
      </div>

      <div class="form-hint">
        <button class="btn btn-primary" type="submit" style="margin-top:0;">
          <?= htmlspecialchars($f['submit']) ?>
        </button>
      </div>
    </form>

    <div class="log-wall">
      <p class="log-wall-title"><?= htmlspecialchars($f['wall_title']) ?> <?= MIDDOT ?> <?= count($entries) ?></p>

      <?php if (!$entries): ?>
        <p class="log-empty"><?= htmlspecialchars($f['wall_empty']) ?></p>
      <?php else: ?>
        <?php foreach ($entries as $entry): ?>
          <article class="log-entry">
            <p class="log-entry-sentence"><?= htmlspecialchars($entry['sentence']) ?></p>
            <?php if (!empty($entry['note'])): ?>
              <p class="log-entry-note"><?= htmlspecialchars($entry['note']) ?></p>
            <?php endif; ?>
            <p class="log-entry-date"><?= htmlspecialchars(french_log_format_date($entry['created_at'], $lang)) ?></p>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
