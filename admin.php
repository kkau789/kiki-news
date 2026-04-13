<?php
session_start();

$ADMIN_USER = "admin";
$ADMIN_PASS = "1234"; // CHANGE THIS LATER

$file = "tickets.json";

if (!file_exists($file)) {
    file_put_contents($file, "[]");
}

$data = json_decode(file_get_contents($file), true);

if (!is_array($data)) {
    $data = [];
}

// LOGIN SYSTEM
if (!isset($_SESSION["admin"])) {

    if (isset($_POST["login"])) {
        if ($_POST["user"] === $ADMIN_USER && $_POST["pass"] === $ADMIN_PASS) {
            $_SESSION["admin"] = true;
        } else {
            echo "❌ Wrong Login";
        }
    }

    if (!isset($_SESSION["admin"])) {
?>
<h2>🔐 Admin Login</h2>

<form method="POST">
    <input name="user" placeholder="Username"><br><br>
    <input name="pass" type="password" placeholder="Password"><br><br>
    <button name="login">Login</button>
</form>

<?php
exit;
    }
}
?>

<h1>🔥 Admin Dashboard</h1>

<a href="logout.php">Logout</a>

<hr>

<?php foreach ($data as $t) { ?>

<div style="border:1px solid #000; padding:10px; margin:10px;">
    <b>ID:</b> <?= $t["id"] ?><br>
    <b>Message:</b> <?= $t["message"] ?><br>
    <b>Status:</b> <?= $t["status"] ?><br>
    <b>Reply:</b> <?= $t["reply"] ?><br>

    <form method="POST" action="reply.php">
        <input type="hidden" name="id" value="<?= $t["id"] ?>">
        <input name="reply" placeholder="Write reply..." required>
        <button type="submit">Send Reply</button>
    </form>
</div>

<?php } ?>
