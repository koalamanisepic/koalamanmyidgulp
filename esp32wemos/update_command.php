<?php
// Get parameters from the URL
$dir = isset($_GET['dir']) ? intval($_GET['dir']) : 0;
$spd = isset($_GET['spd']) ? intval($_GET['spd']) : 0;

// Format data as "DIR,SPEED" (e.g., "1,150")
$data = $dir . "," . $spd;

// Write it directly into command.txt
file_put_contents("command.txt", $data);

echo "Success: Wrote " . $data;
?>