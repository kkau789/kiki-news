<?php
$apiKey = "8eb1b42cae277b04224e7487f6eb9c2c";

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

.btn {
  display: inline-block;
  margin-top: 10px;
  padding: 8px 12px;
  background: #ff3b3b;
  color: white;
  text-decoration: none;
  border-radius: 6px;
}

/* YOUR CHAT */
#chat-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #ff3b3b;
  padding: 12px;
  cursor: pointer;
}

#chat-box {
  position: fixed;
  bottom: 70px;
  right: 20px;
  width: 300px;
  background: #1e1e1e;
  display: none;
}

#chat-header {
  background: #ff3b3b;
  padding: 10px;
}

#chat-body {
  height: 200px;
  overflow-y: auto;
  padding: 10px;
}

#chat-form {
  display: flex;
}

#chat-form input {
  flex: 1;
  padding: 8px;
}

#chat-form button {
  padding: 8px;
  background: #ff3b3b;
  color: white;
  border: none;
}
</style>
</head>

<body>

<div class="header">NewsFresh</div>

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
<h3><?php echo $news['title']; ?></h3>
<p><?php echo $news['description']; ?></p>

<a class="btn" href="<?php echo $news['url']; ?>" target="_blank">
Read More
</a>
</div>
</div>

<?php } } ?>

</div>

<!-- YOUR CHAT -->
<div id="chat-btn" onclick="openChat()">Support</div>

<div id="chat-box">
  <div id="chat-header">
    News Fresh Support
    <span onclick="closeChat()" style="float:right;">X</span>
  </div>

  <div id="chat-body">
    <div>Welcome. How can we help?</div>
  </div>

  <form id="chat-form">
    <input id="msg" placeholder="Type..." required>
    <button>Send</button>
  </form>
</div>

<script>
function openChat() {
  document.getElementById("chat-box").style.display = "block";
}

function closeChat() {
  document.getElementById("chat-box").style.display = "none";
}

document.getElementById("chat-form").addEventListener("submit", function(e) {
  e.preventDefault();

  let msg = document.getElementById("msg").value;

  let div = document.createElement("div");
  div.style.textAlign = "right";
  div.innerText = msg;
  document.getElementById("chat-body").appendChild(div);

  fetch("support.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "message=" + encodeURIComponent(msg)
  });

  document.getElementById("msg").value = "";
});
</script>

</body>
</html>
