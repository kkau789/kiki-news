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

/* CHAT BUTTON */
#chat-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 55px;
  height: 55px;
  background: #ff3b3b;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  cursor: pointer;
}

/* CHAT BOX */
#chat-box {
  position: fixed;
  bottom: 80px;
  right: 20px;
  width: 300px;
  background: #1e1e1e;
  border-radius: 10px;
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
  font-size: 13px;
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

<!-- CHAT BUTTON -->
<div id="chat-btn" onclick="openChat()">💬</div>

<!-- CHAT BOX -->
<div id="chat-box">
  <div id="chat-header">
    News Fresh Support
    <span onclick="closeChat()" style="float:right;cursor:pointer;">X</span>
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

/* SEND MESSAGE */
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

/* FETCH REPLIES */
let lastReply = "";

setInterval(() => {
  fetch("https://api.jsonbin.io/v3/b/69dd19daaaba882197f509b4/latest", {
    headers: {
      "X-Master-Key": "$2a$10$8s5iCInzkF2FNn3aSgijbOgbK.zV0wyk2gguS14iLMmDjXR2AFQwu"
    }
  })
  .then(res => res.json())
  .then(data => {
    let tickets = data.record || [];

    if (tickets.length > 0) {
      let lastTicket = tickets[tickets.length - 1];

      if (lastTicket.reply && lastTicket.reply !== "" && lastTicket.reply !== lastReply) {

        let div = document.createElement("div");
        div.style.textAlign = "left";
        div.innerText = lastTicket.reply;

        document.getElementById("chat-body").appendChild(div);

        lastReply = lastTicket.reply;
      }
    }
  });

}, 3000);
</script>

</body>
</html>
