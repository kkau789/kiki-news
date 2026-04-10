<?php
header("Content-Type: text/xml");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<Response>
    <Gather numDigits="1" action="menu.php" method="POST">
        <Say voice="alice">
            Welcome to Kiki News Support.
            Press 1 for latest news.
            Press 2 to connect to support.
        </Say>
    </Gather>

    <Say>No input received. Goodbye!</Say>
</Response>
