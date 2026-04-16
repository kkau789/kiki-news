<?php
require 'config.php';
require '../credentials.php';

use Webauthn\PublicKeyCredentialRequestOptions;

$cred = getCredential();

$options = PublicKeyCredentialRequestOptions::create(
    random_bytes(32)
);

$_SESSION['challenge'] = base64_encode($options->getChallenge());

$options->allowCredentials = [[
    "type" => "public-key",
    "id" => base64_decode($cred['id'])
]];

echo json_encode($options);
