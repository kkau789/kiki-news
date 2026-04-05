<?php

$apiKey = "e312fd89e11d44dcb4bf65e7298fada3";

$url = "https://newsapi.org/v2/top-headlines?country=in&apiKey=$apiKey";

$response = file_get_contents($url);
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
foreach ($data['articles'] as $news) {
    echo "<h2>".$news['title']."</h2>";
    echo "<p>".$news['description']."</p>";
}
?>

</body>
</html>
