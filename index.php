<?php

$apiKey = "8eb1b42cae277b04224e7487f6eb9c2c";

$url = "https://gnews.io/api/v4/top-headlines?country=in&lang=en&apikey=$apiKey";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

?>

<!DOCTYPE html>
<html>
<head>
<title>Kiki News</title>
</head>
<body>

<h1>📰 Kiki News</h1>

<?php

if ($data && isset($data['articles'])) {

    foreach ($data['articles'] as $news) {
        echo "<h2>".$news['title']."</h2>";
        echo "<p>".$news['description']."</p>";
    }

} else {
    echo "<p>⚠️ Failed to load news</p>";
}

?>

</body>
</html>
