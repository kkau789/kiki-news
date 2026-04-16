<?php
require __DIR__ . '/../vendor/autoload.php';

use Webauthn\PublicKeyCredentialRpEntity;

session_start();

$rpId = "app.news-fresh.is-great.net";

$rpEntity = new PublicKeyCredentialRpEntity(
    "NewsFresh Admin",
    $rpId
);
