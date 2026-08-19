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
  config.php                 Passphrase shared by the French log and Papers uploader — change this
  french-log.php             Read/write helpers for the French sentence log
  papers-store.php           Upload handling + read/write helpers for Papers
  header.php                 <head>, opening <body>, site navigation
  footer.php                 Closes <main>, site footer, closing tags
lang/
  lang.php                  All UI copy, English and French, one array per language
assets/
  css/style.css              All styles (design tokens live at the top as CSS variables)
  js/main.js                 Mobile nav toggle, dark mode toggle, scroll-reveal, clown mascot
  img/, audio/                Clown mascot image + sound
learning/
  french/index.php           French sentence log: submission form + log wall (live)
  (psychology, sociology, education-and-learning — not built yet, cards link out)
papers/
  index.php                 Papers: upload form + list (live)
  download.php               Streams an uploaded PDF by id
projects/                   Project pages (one folder per project)
```

Note: neither the French log's nor the Papers' actual data lives inside
this folder — see their sections below for where it really goes and why.


Note: the French sentence log's data file is NOT inside this folder — see
below. Nothing under `learning/french/` stores anything itself; it's just
the page code.

## French sentence log

`learning/french/` is a working page, not a placeholder: a form to add a
sentence (plus an optional note), and a log wall of everything submitted so
far.

**The data lives outside the site entirely**, one directory above wherever
you deployed this code — e.g. if this folder is at `/home/youruser/public_html/`,
the log is written to `/home/youruser/koalaman-private-data/french-sentences.json`,
*not* anywhere inside `public_html`. Two reasons:

- There's no HTTP path to it from any host configuration — it's not just
  blocked by an `.htaccess` rule, it's physically outside the folder your
  web server serves at all.
- It's outside the folder tree you redeploy the site into, so re-extracting
  a fresh copy of the code over your live site can never touch it, no
  matter how carelessly you do it.

The folder is created automatically (permissions `0775`) the first time
you submit a sentence — there's nothing to set up by hand. If it fails to
write, your host's PHP config may be sandboxing scripts strictly to
`public_html` only (`open_basedir`); in that case, ask your host to include
your home directory, or move `FRENCH_LOG_DIR` in `includes/french-log.php`
back to somewhere inside the site (e.g. `ROOT_DIR . '/data'`) as a fallback
— just remember to add a `.htaccess` with `Require all denied` in that
folder if you do, same as before.

**Before using it:**

Open `includes/config.php` and change `'change-me'` to a passphrase only you
know. Anyone who has this passphrase can add entries — it's a lightweight
deterrent against casual spam, not real authentication, so don't reuse a
password you use elsewhere.

To read or back up the log outside the site, download
`koalaman-private-data/french-sentences.json` via File Manager (navigate to
your home directory, not `public_html`) — it's plain JSON, one object per
entry (`sentence`, `note`, `created_at`).

**On redeployment:** none of this is in the zip. The log file and its
folder live outside `public_html` and get created automatically, so nothing
about redeploying the site can ever touch your real entries. The one file
that *is* shipped every time is `includes/config.php` (the app won't run
without it) — if you've already set a real passphrase there, just don't
drag that specific file over on a future redeploy.


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

## Dark mode

Toggled via the sun/moon button in the nav (every page). It's set before
first paint by a small inline script at the top of `includes/header.php`, so
there's no flash of the wrong theme on load. The preference is stored in
`localStorage` (key `koalaman-theme`) and falls back to the visitor's OS
preference if they haven't chosen one yet.

In browsers that support the View Transitions API (Chrome, Edge, and recent
Safari), clicking the toggle floods the new theme outward from the button in
a circular reveal. Everywhere else it just swaps instantly — still no
flicker, just no animation. Colours for both themes live in
`assets/css/style.css` under `:root` and `:root[data-theme="dark"]`.


## Scroll-reveal animations

Sections tagged with the `reveal` class fade/slide into view as they scroll
into the viewport (handled by `assets/js/main.js` via IntersectionObserver).
Add or remove the class on a `<section>` to control which ones animate in.
Skipped entirely under `prefers-reduced-motion: reduce`.

## Papers

`papers/` is a third top-level section (alongside Learning and Projects): a
form to upload a PDF with a title and optional description, and a list of
everything uploaded so far, newest first.

**Storage — same pattern as the French log, and for the same reasons:**
uploaded files and their metadata live in
`koalaman-private-data/papers/` and `koalaman-private-data/papers-index.json`,
one directory above wherever this code is deployed — not inside
`public_html`. That means:

- No HTTP path to the raw files or the index exists at all.
- Redeploying/re-extracting the site's code can never touch a paper you've
  already uploaded.
- The actual PDF is renamed to a random id on upload
  (`includes/papers-store.php` → `papers_handle_upload()`) — the original
  filename is only kept as display text, never used as a real path. This
  means an uploaded filename can't be used to overwrite or reach any other
  file on the server.

`papers/download.php` is the only thing that ever serves a file back out,
and it only ever does so by looking up an `id` in the index — never from a
raw filename in the request — so a guessed or tampered id just 404s.

**Validation on upload:** must be a real PDF (checked both by file
extension and by inspecting the actual file content via `finfo`, so
renaming a different file type to `.pdf` won't get through), 20MB max. Both
are adjustable in `includes/papers-store.php` (`PAPERS_MAX_BYTES`, and the
MIME/extension check in `papers_handle_upload()`).

**Passphrase:** uses the same `CONTENT_PASSPHRASE` constant in
`includes/config.php` as the French log — one passphrase gates both
features. Split them by adding a second constant there and referencing it
in `papers/index.php` instead, if you'd rather they differ.

**A note on PHP upload limits:** most hosts cap upload size in PHP itself
(`upload_max_filesize`, `post_max_size` in php.ini), separately from the
20MB check in this code. If a large PDF fails to upload with no clear error,
that's usually why — check your host's PHP settings (cPanel → MultiPHP INI
Editor is the usual place) and raise them if needed.
