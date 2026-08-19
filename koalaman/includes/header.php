<?php
/**
 * Shared header. Expects $t (translations) and $lang to already be set
 * by includes/bootstrap.php, and $canonicalPath (site-root-relative path
 * of the current page, e.g. '' for the homepage or 'learning/psychology/')
 * to be defined by the including page for correct relative asset paths.
 */
$canonicalPath = $canonicalPath ?? '';
$depth = $canonicalPath === '' ? '' : str_repeat('../', substr_count(rtrim($canonicalPath, '/'), '/') + 1);
$base = $depth === '' ? './' : $depth;
$cssVersion = @filemtime(__DIR__ . '/../assets/css/style.css') ?: time();
?>
<!doctype html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>
// Set the theme before first paint so there's no flash of the wrong
// theme. Deliberately inline and synchronous — this must run before
// the stylesheet is applied.
(function () {
  try {
    var stored = localStorage.getItem('koalaman-theme');
    var theme = stored || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    document.documentElement.setAttribute('data-theme', theme);
  } catch (e) {}
})();
</script>
<title><?= htmlspecialchars($t['meta']['title']) ?></title>
<meta name="description" content="<?= htmlspecialchars($t['meta']['description']) ?>">
<link rel="alternate" hreflang="en" href="<?= htmlspecialchars(lang_switch_url('en')) ?>">
<link rel="alternate" hreflang="fr" href="<?= htmlspecialchars(lang_switch_url('fr')) ?>">
<link rel="stylesheet" href="<?= $base ?>assets/css/style.css?v=<?= $cssVersion ?>">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">
</head>
<body>
<a class="visually-hidden" href="#main">Skip to content</a>

<header class="site-header">
  <div class="wrap">
    <a class="brand" href="<?= $base ?>index.php<?= $lang !== 'en' ? '?lang=' . $lang : '' ?>"><?= htmlspecialchars($t['nav']['brand']) ?></a>

    <nav class="nav-primary" id="primary-nav">
      <ul class="nav-links">
        <li><a href="<?= $base ?>index.php<?= $lang !== 'en' ? '?lang=' . $lang : '' ?>#learning"><?= htmlspecialchars($t['nav']['learning']) ?></a></li>
        <li><a href="<?= $base ?>index.php<?= $lang !== 'en' ? '?lang=' . $lang : '' ?>#projects"><?= htmlspecialchars($t['nav']['projects']) ?></a></li>
        <li><a href="<?= $base ?>index.php<?= $lang !== 'en' ? '?lang=' . $lang : '' ?>#papers"><?= htmlspecialchars($t['nav']['papers']) ?></a></li>
      </ul>

      <div class="lang-toggle" role="group" aria-label="Language / Langue">
        <a href="<?= htmlspecialchars(lang_switch_url('en')) ?>" aria-current="<?= $lang === 'en' ? 'true' : 'false' ?>">English</a>
        <span>|</span>
        <a href="<?= htmlspecialchars(lang_switch_url('fr')) ?>" aria-current="<?= $lang === 'fr' ? 'true' : 'false' ?>">Français</a>
      </div>
    </nav>

    <a class="nav-wemos" href="https://koalaman.my.id/esp32wemos/"><?= htmlspecialchars($t['nav']['wemos']) ?> →</a>

    <button type="button" class="theme-toggle" id="theme-toggle" aria-label="<?= htmlspecialchars($t['nav']['theme_toggle']) ?>">
      <span class="theme-toggle-icons">
        <svg class="icon-sun" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="4"></circle>
          <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"></path>
        </svg>
        <svg class="icon-moon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
      </span>
    </button>

    <button class="nav-toggle" aria-label="<?= htmlspecialchars($t['nav']['menu']) ?>" aria-expanded="false" aria-controls="primary-nav">
      <span></span>
    </button>
  </div>
</header>

<main id="main">
