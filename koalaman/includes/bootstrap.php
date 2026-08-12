<?php
/**
 * Shared bootstrap: language resolution + small helpers.
 * Include this at the top of every page, before includes/header.php.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Middle dot separator, built from its raw UTF-8 bytes rather than typed
 * as a literal character. A literal dot character in a source file gets
 * corrupted the moment any tool re-saves that file in a non-UTF-8
 * encoding (this has happened via cPanel's editor before). This escape
 * sequence is plain ASCII in the source, so it survives regardless of
 * file encoding.
 */
if (!defined('MIDDOT')) {
    define('MIDDOT', "\xC2\xB7");
}

/**
 * Absolute path to the project root, regardless of how deep the
 * including page lives (e.g. learning/french/index.php).
 */
if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(__DIR__));
}

$available = ['en', 'fr'];

$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'en');
if (!in_array($lang, $available, true)) {
    $lang = 'en';
}
$_SESSION['lang'] = $lang;

$dict = require __DIR__ . '/../lang/lang.php';
$t = $dict[$lang];

/**
 * Build the URL for switching to another language while staying on the
 * current page (preserves path and any other query parameters).
 */
function lang_switch_url(string $targetLang): string
{
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $parts = parse_url($uri);
    $path = $parts['path'] ?? '/';
    parse_str($parts['query'] ?? '', $query);
    $query['lang'] = $targetLang;
    return $path . '?' . http_build_query($query);
}

/**
 * Append the current language as a query string to a relative internal link,
 * so navigating to another page keeps the chosen language.
 */
function with_lang(string $path, string $lang): string
{
    $sep = (strpos($path, '?') === false) ? '?' : '&';
    return $path . $sep . 'lang=' . urlencode($lang);
}
