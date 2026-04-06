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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kiki News</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #121212;
    color: white;
}

.header {
    padding: 15px;
    font-size: 22px;
    font-weight: bold;
    background: #1f1f1f;
    text-align: center;
    position: sticky;
    top: 0;
}

.container {
    padding: 10px;
}

.card {
    background: #1e1e1e;
    margin-bottom: 15px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.5);
}

.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-content {
    padding: 12px;
}

.card h2 {
    font-size: 16px;
    margin: 0 0 8px;
}

.card p {
    font-size: 13px;
    color: #ccc;
}

.btn {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 12px;
    background: #ff3b3b;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 13px;
}
</style>

</head>

<body>

<div class="header">📰 Kiki News</div>

<div class="container">

<?php

if ($data && isset($data['articles'])) {

    foreach ($data['articles'] as $news) {
?>
        <div class="card">

            <?php if (!empty($news['image'])) { ?>
                <img src="<?php echo $news['image']; ?>">
            <?php } ?>

            <div class="card-content">
                <h2><?php echo $news['title']; ?></h2>
                <p><?php echo $news['description']; ?></p>

                <a class="btn" href="<?php echo $news['url']; ?>" target="_blank">
                    Read More →
                </a>
            </div>

        </div>
<?php
    }

} else {
    echo "<p style='text-align:center;color:red;'>⚠️ Failed to load news</p>";
}

?>

</div>

</body>
</html>
