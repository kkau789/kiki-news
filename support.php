<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $file = "tickets.json";
    $data = json_decode(file_get_contents($file), true);

    $ticket = [
        "id" => "NF" . rand(1000,9999),
        "message" => $_POST["message"],
        "reply" => "",
        "status" => "open",
        "time" => date("Y-m-d H:i:s")
    ];

    $data[] = $ticket;

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    echo "🔥 Ticket Created: " . $ticket["id"];
}
?>

<h2>📩 NewsFresh Support</h2>

<form method="POST">
    <input name="message" placeholder="Write your issue..." required>
    <button type="submit">Send</button>
</form>
