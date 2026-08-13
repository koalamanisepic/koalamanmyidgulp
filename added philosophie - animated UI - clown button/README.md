# Koalaman — Learning Log

Source for `https://koalaman.my.id`. Plain PHP, no framework, no build step.
Upload the contents of this folder to the web root and it runs as-is (PHP 7.4+).

**Do not overwrite `/esp32wemos/`** — that is the existing, separate ESP32/Wemos
controller and is untouched by this codebase. The homepage only links to it.

## Structure

```
index.php                  Homepage
favicon.ico, favicon.svg, favicon-96x96.png,
apple-touch-icon.png, web-app-manifest-*.png,
site.webmanifest           Favicon set — must stay at the site root (not in assets/)
includes/
  bootstrap.php             Language resolution + helper functions (include first, always)
  config.php                 Passphrase for the French sentence log — change this
  french-log.php             Read/write helpers for the French sentence log (JSON storage)
  header.php                 <head>, opening <body>, site navigation
  footer.php                 Closes <main>, site footer, closing tags
lang/
  lang.php                  All UI copy, English and French, one array per language
assets/
  css/style.css              All styles (design tokens live at the top as CSS variables)
  js/main.js                 Mobile nav toggle only — no other JS on the site
data/
  french-sentences.json      Storage for the French sentence log (must stay writable)
  .htaccess                  Blocks direct web access to this folder
learning/
  french/index.php           French sentence log: submission form + log wall (live)
  (psychology, sociology, education-and-learning — not built yet, cards link out)
projects/                   Project pages (one folder per project)
```

## French sentence log

`learning/french/` is a working page, not a placeholder: a form to add a
sentence (plus an optional note), and a log wall of everything submitted so
far, stored in `data/french-sentences.json`.

**Before using it:**

1. Open `includes/config.php` and change `'change-me'` to a passphrase only
   you know. Anyone who has this passphrase can add entries — it's a
   lightweight deterrent against casual spam, not real authentication, so
   don't reuse a password you use elsewhere.
2. Make sure `data/` is writable by the web server. On most cPanel hosts
   folders default to `0755` and that's already enough; if you get a
   "could not open the log file" style error, set `data/` to `0775` via
   File Manager → Permissions.
3. `data/.htaccess` blocks direct web requests to the JSON file itself —
   don't delete it, or the raw log becomes fetchable at
   `koalaman.my.id/data/french-sentences.json`.

To read or back up the log outside the site, just download
`data/french-sentences.json` — it's plain JSON, one object per entry
(`sentence`, `note`, `created_at`).

## Adding a new page

Every page follows the same three-part pattern. Example — a new project page at
`projects/my-new-project/index.php`:

```php
<?php
require __DIR__ . '/../../includes/bootstrap.php';
$canonicalPath = 'projects/my-new-project/'; // used to compute relative asset paths
require __DIR__ . '/../../includes/header.php';
?>

<section class="section section--tight">
  <div class="wrap" style="max-width: 760px;">
    <!-- page content -->
  </div>
</section>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
```

`$canonicalPath` only needs to reflect how many folders deep the file is — the
header uses it to build the correct number of `../` for `assets/`.

Then link to the page from `lang/lang.php` (see the `'link'` keys under
`learning` and `projects.featured`) so both languages point
to it and the language is preserved automatically via `with_lang()`.

## Adding or editing copy

All UI text lives in `lang/lang.php`, split into `'en'` and `'fr'`. Keep the
same key structure in both arrays. Nothing else in the codebase should contain
hardcoded English or French strings — if you find a hardcoded string in a
template, move it into the dictionary.

## Adding a third language

1. Duplicate the `'fr'` array in `lang/lang.php`, give it a new key (e.g. `'id'`), and translate every value.
2. Add the language code to `$available` in `includes/bootstrap.php`.
3. Add a link in the `.lang-toggle` block in `includes/header.php`.

## Notes

- Language choice is carried both by a `?lang=` query parameter (so links and
  the language switch are shareable/bookmarkable) and by a session fallback
  (so navigating without the parameter keeps the last choice).
- No browser storage, no client-side translation — every string is rendered
  server-side from `lang/lang.php`.
- The "LR·01 / PR·01 / RQ·01 / JL·01" labels are catalogue-style reference
  codes, not step numbers — safe to keep incrementing as records are added.

## Clown mascot

There's a floating clickable mascot (bottom-right, every page) that plays a
sound and does a little squash-bounce animation on click. It's purely
decorative — swap `assets/img/clown-avatar.png` and
`assets/audio/clown-nose-squeak.mp3` for different files (same names) to
change it, or delete the mascot block near the bottom of `includes/footer.php`
to remove it entirely. It respects `prefers-reduced-motion` (animation is
skipped, but the sound still plays).

## Scroll-reveal animations

Sections tagged with the `reveal` class fade/slide into view as they scroll
into the viewport (handled by `assets/js/main.js` via IntersectionObserver).
Add or remove the class on a `<section>` to control which ones animate in.
Skipped entirely under `prefers-reduced-motion: reduce`.

