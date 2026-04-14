<?php
session_start();

/* USERS */
$USERS = [
    "admin" => "1234"
];

/* CONFIG */
$BIN_ID = "69dd19daaaba882197f509b4";
$API_KEY = "$2a$10$8s5iCInzkF2FNn3aSgijbOgbK.zV0wyk2gguS14iLMmDjXR2AFQwu";

/* LOGOUT */
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

/* LOGIN */
if (!isset($_SESSION["admin"])) {

    if (isset($_POST["login"])) {
        if (isset($USERS[$_POST["user"]]) && $USERS[$_POST["user"]] === $_POST["pass"]) {
            $_SESSION["admin"] = $_POST["user"];
        } else {
            $error = "Invalid login";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.box {
    background: white;
    padding: 25px;
    width: 320px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
input, button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
}
button {
    background: black;
    color: white;
    border: none;
}
.error {
    color: red;
}
</style>
</head>
<body>

<div class="box">
<h2>Admin Login</h2>
<?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
<form method="POST">
<input name="user" placeholder="Username" required>
<input type="password" name="pass" placeholder="Password" required>
<button name="login">Login</button>
</form>
</div>

</body>
</html>
<?php
exit;
}

/* FETCH DATA */
$ch = curl_init("https://api.jsonbin.io/v3/b/$BIN_ID/latest");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-Master-Key: $API_KEY"
]);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$tickets = $data["record"] ?? [];

/* REPLY HANDLER */
if (isset($_POST["reply"]) && isset($_POST["ticket_id"])) {

    foreach ($tickets as &$t) {
        if (isset($t["id"]) && $t["id"] === $_POST["ticket_id"]) {
            $t["reply"] = $_POST["reply"];
            $t["status"] = "replied";
        }
    }

    $ch = curl_init("https://api.jsonbin.io/v3/b/$BIN_ID");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "X-Master-Key: $API_KEY"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($tickets));
    curl_exec($ch);
    curl_close($ch);

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    margin: 0;
}
.header {
    background: black;
    color: white;
    padding: 15px 25px;
    display: flex;
    justify-content: space-between;
}
.header a {
    color: white;
    text-decoration: none;
}
.container {
    padding: 25px;
}
.welcome {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 20px;
}
.ticket {
    background: white;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.ticket b {
    display: inline-block;
    width: 100px;
}
.ticket input {
    width: 100%;
    padding: 8px;
    margin-top: 10px;
}
.ticket button {
    margin-top: 8px;
    padding: 8px;
    background: black;
    color: white;
    border: none;
}
</style>
</head>
<body>

<div class="header">
    <div>News Fresh Studios</div>
    <div><a href="?logout=true">Logout</a></div>
</div>

<div class="container">

<div class="welcome">
Welcome, <?php echo ucfirst($_SESSION["admin"]); ?>, News Fresh Studios
</div>

<?php if (!empty($tickets)) { ?>

    <?php foreach ($tickets as $t) { ?>

        <div class="ticket">
            <div><b>ID:</b> <?php echo isset($t["id"]) ? $t["id"] : ""; ?></div>
            <div><b>Message:</b> <?php echo isset($t["message"]) ? $t["message"] : ""; ?></div>
            <div><b>Status:</b> <?php echo isset($t["status"]) ? $t["status"] : "open"; ?></div>

            <?php if (isset($t["reply"]) && $t["reply"] !== "") { ?>
                <div><b>Reply:</b> <?php echo $t["reply"]; ?></div>
            <?php } ?>

            <form method="POST">
                <input type="hidden" name="ticket_id" value="<?php echo isset($t["id"]) ? $t["id"] : ""; ?>">
                <input name="reply" placeholder="Write reply..." required>
                <button type="submit">Reply</button>
            </form>
        </div>

    <?php } ?>

<?php } else { ?>
    <p>No tickets available</p>
<?php } ?>

</div>

</body>
</html>
