<?php
/**
 * Storage for uploaded papers (PDFs). Same philosophy as
 * includes/french-log.php: everything lives ONE LEVEL ABOVE public_html,
 * so there's no HTTP path to the raw files or the index, and redeploying
 * the site's code can never touch what's been uploaded.
 *
 * Layout inside the private storage folder:
 *   koalaman-private-data/
 *     papers-index.json      metadata: id, title, description, stored
 *                             filename, original filename, size, date
 *     papers/
 *       <random-id>.pdf       the actual files, renamed on upload so an
 *                             uploaded filename can never be used to
 *                             overwrite or execute anything unexpected
 *
 * papers/download.php is the only thing that ever reads a file back out,
 * and it only ever does so via an id looked up in the index — never from
 * a raw filename supplied by the request.
 */

if (!defined('PAPERS_PRIVATE_DIR')) {
    define('PAPERS_PRIVATE_DIR', dirname(ROOT_DIR) . '/koalaman-private-data');
}

if (!defined('PAPERS_FILES_DIR')) {
    define('PAPERS_FILES_DIR', PAPERS_PRIVATE_DIR . '/papers');
}

if (!defined('PAPERS_INDEX_FILE')) {
    define('PAPERS_INDEX_FILE', PAPERS_PRIVATE_DIR . '/papers-index.json');
}

const PAPERS_MAX_BYTES = 20 * 1024 * 1024; // 20MB

/**
 * @return array<int, array{id:string, title:string, description:string, filename:string, original_name:string, size:int, uploaded_at:string}>
 */
function papers_index_read(): array
{
    if (!file_exists(PAPERS_INDEX_FILE)) {
        return [];
    }

    $fp = fopen(PAPERS_INDEX_FILE, 'r');
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

function papers_index_write(array $entries): void
{
    $fp = fopen(PAPERS_INDEX_FILE, 'c+');
    if (!$fp) {
        throw new RuntimeException('Could not open the papers index for writing.');
    }

    flock($fp, LOCK_EX);
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
}

/**
 * Validates and stores an uploaded PDF from $_FILES, returns any
 * validation error message, or null on success.
 *
 * $writtenAt is an optional 'YYYY-MM-DD' string (from an HTML date
 * input) for when the paper was actually written, as distinct from
 * $uploaded_at below, which is always just "now". Anything that
 * doesn't look like a real date is silently dropped rather than
 * blocking the upload — it's a minor display field, not worth failing
 * the whole form over.
 */
function papers_handle_upload(array $file, string $title, string $description, string $writtenAt): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return 'error_no_file';
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return 'error_upload_failed';
    }
    if ($file['size'] <= 0 || $file['size'] > PAPERS_MAX_BYTES) {
        return 'error_too_large';
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        return 'error_upload_failed';
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $extension = strtolower((string) pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($mime !== 'application/pdf' || $extension !== 'pdf') {
        return 'error_not_pdf';
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $writtenAt) || !strtotime($writtenAt)) {
        $writtenAt = '';
    }

    if (!is_dir(PAPERS_FILES_DIR)) {
        if (!mkdir(PAPERS_FILES_DIR, 0775, true) && !is_dir(PAPERS_FILES_DIR)) {
            return 'error_storage';
        }
    }

    $id = bin2hex(random_bytes(8));
    $storedName = $id . '.pdf';
    $destination = PAPERS_FILES_DIR . '/' . $storedName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return 'error_storage';
    }

    $entries = papers_index_read();
    $entries[] = [
        'id'            => $id,
        'title'         => $title,
        'description'   => $description,
        'filename'      => $storedName,
        'original_name' => basename($file['name']),
        'size'          => $file['size'],
        'written_at'    => $writtenAt,
        'uploaded_at'   => date('c'),
    ];
    papers_index_write($entries);

    return null;
}

function papers_find(string $id): ?array
{
    foreach (papers_index_read() as $entry) {
        if (hash_equals($entry['id'], $id)) {
            return $entry;
        }
    }
    return null;
}
