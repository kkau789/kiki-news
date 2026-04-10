<?php
header("Content-type: text/xml");

$digit = $_POST['Digits'];

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

if ($digit == "1") {
    echo "<Response><Say>Here are the latest headlines from Kiki News.</Say></Response>";
}
else if ($digit == "2") {
    echo "<Response><Say>Connecting you to support... Please wait.</Say></Response>";
}
else {
    echo "<Response><Say>Invalid input. Goodbye!</Say></Response>";
}
?>
