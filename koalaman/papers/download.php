<?php
require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/papers-store.php';

$id = (string) ($_GET['id'] ?? '');
$entry = $id !== '' ? papers_find($id) : null;

if (!$entry) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Not found.';
    exit;
}

$path = PAPERS_FILES_DIR . '/' . $entry['filename'];

if (!is_file($path)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Not found.';
    exit;
}

$downloadName = preg_replace('/[^A-Za-z0-9 ._-]/', '_', $entry['original_name']) ?: 'paper.pdf';

header('Content-Type: application/pdf');
header('Content-Length: ' . filesize($path));
header('Content-Disposition: inline; filename="' . $downloadName . '"');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, max-age=0, must-revalidate');

readfile($path);
