<?php
header("Content-Type: text/xml");

$input = isset($_POST['Digits']) ? $_POST['Digits'] : '';

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<Response>

<?php if ($input == "1") { ?>

<Say voice="alice">Here are the latest headlines from Kiki News.</Say>

<?php } elseif ($input == "2") { ?>

<Say voice="alice">Connecting you to support.</Say>
<Dial timeout="20">+918334063684</Dial>

<?php } else { ?>

<Say voice="alice">No input detected. Please try again.</Say>
<Redirect method="POST">https://app.news-fresh.is-great.net/ivr.php</Redirect>

<?php } ?>
</Response><?php
