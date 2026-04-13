<?php
session_start();

if (!isset($_SESSION["admin"])) {
    die("Access Denied");
}

$file = "tickets.json";
$data = json_decode(file_get_contents($file), true);

if (!is_array($data)) {
    $data = [];
}

foreach ($data as &$t) {
    if ($t["id"] == $_POST["id"]) {
        $t["reply"] = $_POST["reply"];
        $t["status"] = "answered";
    }
}

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

echo "🔥 Reply Sent!";
?>
