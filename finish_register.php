<?php
require 'config.php';
require '../credentials.php';

use Webauthn\AuthenticatorAttestationResponseValidator;
use Webauthn\PublicKeyCredentialLoader;
use Webauthn\PublicKeyCredentialSourceRepository;
use Webauthn\TokenBinding\TokenBindingNotSupportedHandler;

$data = json_decode(file_get_contents("php://input"), true);

$loader = new PublicKeyCredentialLoader();
$publicKeyCredential = $loader->load(json_encode($data));

$validator = new AuthenticatorAttestationResponseValidator(
    new PublicKeyCredentialSourceRepository(),
    null,
    new TokenBindingNotSupportedHandler()
);

$credentialSource = $validator->check(
    $publicKeyCredential->getResponse(),
    base64_decode($_SESSION['challenge']),
    $rpEntity,
    $_SERVER['HTTP_HOST']
);

saveCredential([
    "id" => base64_encode($credentialSource->getPublicKeyCredentialId()),
    "publicKey" => base64_encode($credentialSource->getCredentialPublicKey()),
    "counter" => $credentialSource->getCounter()
]);

echo "REGISTERED 🔐";
