<?php

$BIN_ID = "69dd19daaaba882197f509b4";
$API_KEY = "$2a$10$8s5iCInzkF2FNn3aSgijbOgbK.zV0wyk2gguS14iLMmDjXR2AFQwu";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newTicket = [
        "id" => "NF" . rand(1000,9999),
        "message" => $_POST["message"],
        "status" => "open",
        "reply" => "",
        "time" => date("Y-m-d H:i:s")
    ];

    // GET
    $ch = curl_init("https://api.jsonbin.io/v3/b/$BIN_ID/latest");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-Master-Key: $API_KEY"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    $tickets = $data["record"] ?? [];

    // ADD
    $tickets[] = $newTicket;

    // SAVE
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

    $success = "Ticket sent successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Support</title>
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
    width: 350px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
h2 {
    margin-bottom: 15px;
}
textarea {
    width: 100%;
    padding: 10px;
    height: 100px;
}
button {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background: black;
    color: white;
    border: none;
}
.success {
    color: green;
}
</style>
</head>
<body>

<div class="box">
<h2>📩 Contact Support</h2>

<?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

<form method="POST">
    <textarea name="message" placeholder="Write your issue..." required></textarea>
    <button type="submit">Send</button>
</form>

</div>

</body>
</html>
