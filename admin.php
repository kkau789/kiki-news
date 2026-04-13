<?php
session_start();

$ADMIN_USER = "admin";
$ADMIN_PASS = "1234"; // change this

$BIN_ID = "69dd19daaaba882197f509b4";
$API_KEY = "$2a$10$8s5iCInzkF2FNn3aSgijbOgbK.zV0wyk2gguS14iLMmDjXR2AFQwu";

// LOGIN CHECK
if (!isset($_SESSION["admin"])) {

    if (isset($_POST["login"])) {
        if ($_POST["user"] === $ADMIN_USER && $_POST["pass"] === $ADMIN_PASS) {
            $_SESSION["admin"] = true;
        } else {
            echo "❌ Wrong Username or Password";
        }
    }

    if (!isset($_SESSION["admin"])) {
?>
        <h2>🔐 Admin Login</h2>

        <form method="POST">
            <input name="user" placeholder="Username" required><br><br>
            <input name="pass" type="password" placeholder="Password" required><br><br>
            <button name="login">Login</button>
        </form>

<?php
        exit;
    }
}

// FETCH TICKETS FROM JSONBIN
$url = "https://api.jsonbin.io/v3/b/$BIN
