<?php
/**
 * Storage for the French sentence log. Plain JSON file, guarded with
 * flock() so two near-simultaneous submissions can't corrupt it.
 * Swap this out for a database later without touching the page code —
 * just keep the same function signatures.
 *
 * Deliberately stored ONE LEVEL ABOVE public_html (i.e. outside the web
 * root entirely), not inside it. Two reasons:
 *   1. There's no HTTP path to it at all, from any host config — safer
 *      than relying on data/.htaccess alone to block requests.
 *   2. It sits outside the folder tree you redeploy into, so re-extracting
 *      a fresh copy of the site can never touch it.
 * The folder is created automatically on first write — nothing to set up
 * by hand.
 */

if (!defined('FRENCH_LOG_DIR')) {
    define('FRENCH_LOG_DIR', dirname(ROOT_DIR) . '/koalaman-private-data');
}

if (!defined('FRENCH_LOG_FILE')) {
    define('FRENCH_LOG_FILE', FRENCH_LOG_DIR . '/french-sentences.json');
}

/**
 * @return array<int, array{id:string, sentence:string, note:string, created_at:string}>
 */
function french_log_read(): array
{
    if (!file_exists(FRENCH_LOG_FILE)) {
        return [];
    }

    $fp = fopen(FRENCH_LOG_FILE, 'r');
    if (!$fp) {
        return [];
    }

    flock($fp, LOCK_SH);
    $raw = stream_get_contents($fp);
    flock($fp, LOCK_UN);
    fclose($fp);

    $data = json_decode((string) $raw, true);
    return is_array($data) ? $data : [];
}

function french_log_add(string $sentence, string $note): void
{
    if (!is_dir(FRENCH_LOG_DIR)) {
        if (!mkdir(FRENCH_LOG_DIR, 0775, true) && !is_dir(FRENCH_LOG_DIR)) {
            throw new RuntimeException('Could not create the log storage folder outside public_html. Check that the web server has write access to your home directory.');
        }
    }

    $fp = fopen(FRENCH_LOG_FILE, 'c+');
    if (!$fp) {
        throw new RuntimeException('Could not open the log file for writing.');
    }

    flock($fp, LOCK_EX);

    $raw = stream_get_contents($fp);
    $entries = json_decode((string) $raw, true);
    if (!is_array($entries)) {
        $entries = [];
    }

    $entries[] = [
        'id'         => bin2hex(random_bytes(6)),
        'sentence'   => $sentence,
        'note'       => $note,
        'created_at' => date('c'),
    ];

    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    fflush($fp);

    flock($fp, LOCK_UN);
    fclose($fp);
}

