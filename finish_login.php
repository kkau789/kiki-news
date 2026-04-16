<?php
require 'config.php';
require '../credentials.php';

use Webauthn\AuthenticatorAssertionResponseValidator;
use Webauthn\PublicKeyCredentialLoader;
use Webauthn\PublicKeyCredentialSource;

$data = json_decode(file_get_contents("php://input"), true);

$cred = getCredential();

$loader = new PublicKeyCredentialLoader();
$publicKeyCredential = $loader->load(json_encode($data));

$credentialSource = new PublicKeyCredentialSource(
    base64_decode($cred['id']),
    "public-key",
    [],
    base64_decode($cred['publicKey']),
    "app.news-fresh.is-great.net",
    0,
    $cred['counter']
);

$validator = new AuthenticatorAssertionResponseValidator();

$result = $validator->check(
    $credentialSource,
    $publicKeyCredential->getResponse(),
    base64_decode($_SESSION['challenge']),
    $_SERVER['HTTP_HOST']
);

// update counter
saveCredential([
    "id" => $cred['id'],
    "publicKey" => $cred['publicKey'],
    "counter" => $result->getCounter()
]);

$_SESSION['admin_auth'] = true;

echo "LOGIN SUCCESS";
