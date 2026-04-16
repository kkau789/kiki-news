<?php
require 'config.php';

use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialUserEntity;

$user = new PublicKeyCredentialUserEntity(
    "admin",
    random_bytes(16),
    "admin"
);

$options = PublicKeyCredentialCreationOptions::create(
    $rpEntity,
    $user,
    random_bytes(32)
);

$_SESSION['challenge'] = base64_encode($options->getChallenge());

echo json_encode($options);
