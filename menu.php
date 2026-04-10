<?php
header("Content-Type: text/xml");

$input = $_POST['Digits'] ?? '';

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<Response>
<?php if ($input == "1") { ?>

<Say voice="alice">Here are the latest headlines from Kiki News.</Say>

<?php } elseif ($input == "2") { ?>

<Say voice="alice">Connecting you to support.</Say>
<Dial>+918334063684</Dial>

<?php } else { ?>

<Say voice="alice">Invalid input. Goodbye.</Say>

<?php } ?>
</Response>
