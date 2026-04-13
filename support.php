<?php
$BIN_ID = "69dd19daaaba882197f509b4";
$API_KEY = "$2a$10$8s5iCInzkF2FNn3aSgijbOgbK.zV0wyk2gguS14iLMmDjXR2AFQwu";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newTicket = [
        "id" => "NF" . rand(1000,9999),
        "message" => $_POST["message"],
        "status" => "open",
        "time" => date("Y-m-d H:i:s")
    ];

    // GET existing tickets
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

    if (!is_array($tickets)) {
        $tickets = [];
    }

    // ADD new ticket
    $tickets[] = $newTicket;

    // SAVE back
    $saveUrl = "https://api.jsonbin.io/v3/b/$BIN_ID";

    $ch = curl_init($saveUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "X-Master-Key: $API_KEY"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($tickets));

    curl_exec($ch);
    curl_close($ch);

    echo "🔥 Ticket Created Successfully!";
}
?>

<h2>📩 Support System</h2>

<form method="POST">
    <input name="message" placeholder="Write your issue..." required>
    <button type="submit">Send Ticket</button>
</form>
