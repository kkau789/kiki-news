<?php
$apiKey = "8eb1b42cae277b04224e7487f6eb9c2c";

// Fetch news
$url = "https://gnews.io/api/v4/top-headlines?lang=en&country=in&max=10&apikey=$apiKey";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NewsFresh</title>

<!-- 🔥 CHATWAY (your new chat system) -->
<script id="chatway" async="true" src="https://cdn.chatway.app/widget.js?id=ERAoCY1540xz"></script>

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
}

.container {
  padding: 10px;
}

.card {
  background: #1e1e1e;
  margin-bottom: 15px;
  border-radius: 15px;
  overflow: hidden;
}

.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.card-content {
  padding: 12px;
}

.card h3 {
  font-size: 16px;
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
}
</style>
</head>

<body>

<div class="header">📰 NewsFresh</div>

<div class="container">

<?php
if ($data && isset($data['articles']) && !empty($data['articles'])) {

  foreach ($data['articles'] as $news) {
?>

<div class="card">

<?php if (!empty($news['image'])) { ?>
<img src="<?php echo $news['image']; ?>">
<?php } ?>

<div class="card-content">
<h3><?php echo $news['title']; ?></h3>
<p><?php echo $news['description']; ?></p>

<a class="btn" href="<?php echo $news['url']; ?>" target="_blank">
Read More →
</a>
</div>

</div>

<?php
  }

} else {
  echo "<p style='text-align:center;'>No news available</p>";
}
?>

</div>

</body>
</html>
