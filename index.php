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

<!-- CHATWAY (UNCHANGED) -->
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

/* 🔥 YOUR CHAT UI */
#my-chat-button {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background: #ff3b3b;
    color: white;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
}

#my-chat-box {
    position: fixed;
    bottom: 70px;
    left: 20px;
    width: 300px;
    background: #1e1e1e;
    color: white;
    border-radius: 10px;
    display: none;
}

#my-chat-header {
    background: #ff3b3b;
    padding: 10px;
    font-weight: bold;
}

#my-chat-body {
    height: 200px;
    overflow-y: auto;
    padding: 10px;
    font-size: 13px;
}

#my-chat-form {
    display: flex;
}

#my-chat-form input {
    flex: 1;
    padding: 8px;
    border: none;
}

#my-chat-form button {
    padding: 8px;
    background: #ff3b3b;
    color: white;
    border: none;
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

<!-- 🔥 YOUR CUSTOM CHAT -->
<div id="my-chat-button" onclick="openMyChat()">Support</div>

<div id="my-chat-box">
    <div id="my-chat-header">
        News Fresh Studios Support
        <span onclick="closeMyChat()" style="float:right;cursor:pointer;">X</span>
    </div>

    <div id="my-chat-body">
        <div>Welcome. How can we help you?</div>
    </div>

    <form id="my-chat-form">
        <input type="text" id="my-msg" placeholder="Type your message..." required>
        <button type="submit">Send</button>
    </form>
</div>

<script>
function openMyChat() {
    document.getElementById("my-chat-box").style.display = "block";
}

function closeMyChat() {
    document.getElementById("my-chat-box").style.display = "none";
}

document.getElementById("my-chat-form").addEventListener("submit", function(e) {
    e.preventDefault();

    let msg = document.getElementById("my-msg").value;

    let div = document.createElement("div");
    div.style.textAlign = "right";
    div.innerText = msg;
    document.getElementById("my-chat-body").appendChild(div);

    fetch("support.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "message=" + encodeURIComponent(msg)
    });

    document.getElementById("my-msg").value = "";
});
</script>

</body>
</html>
