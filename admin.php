<?php
session_start();
$ADMIN_USER = "admin";
$ADMIN_PASS = "500023";
$BIN_ID = "69dd19daaaba882197f509b4";
$API_KEY = "$2a$10$8s5iCInzkF2FNn3aSgijbOgbK.zV0wyk2gguS14iLMmDjXR2AFQwu";

// HANDLE LOGOUT
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// LOGIN CHECK
if (!isset($_SESSION["admin"])) {

    if (isset($_POST["login"])) {
        if ($_POST["user"] === $ADMIN_USER && $_POST["pass"] === $ADMIN_PASS) {
            $_SESSION["admin"] = true;
        } else {
            echo "<p>❌ Wrong Username or Password</p>";
        }
    }

    echo '
    <h2>🔐 Admin Login</h2>
    <form method="POST">
        <input name="user" placeholder="Username" required><br><br>
        <input name="pass" type="password" placeholder="Password" required><br><br>
        <button name="login">Login</button>
    </form>
    ';
    exit;
}

// FETCH TICKETS
$url = "https://api.jsonbin.io/v3/b/$BIN_ID/latest";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-Master-Key: $API_KEY"
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$tickets = $data["record"] ?? [];

// UI OUTPUT
echo "<h1>🔥 NewsFresh Admin Dashboard</h1>";
echo '<a href="?logout=true">Logout</a>';
echo "<hr>";

if (!empty($tickets)) {
    foreach ($tickets as $t) {
        echo "<div style='border:1px solid black; padding:10px; margin:10px;'>";
        echo "<b>Ticket ID:</b> " . $t["id"] . "<br>";
        echo "<b>Message:</b> " . $t["message"] . "<br>";
        echo "<b>Status:</b> " . $t["status"] . "<br>";
        echo "<b>Time:</b> " . $t["time"] . "<br>";
        echo "</div>";
    }
} else {
    echo "<p>No tickets yet 😄</p>";
}
?>
