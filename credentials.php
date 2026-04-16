<?php

function saveCredential($data) {
    file_put_contents("credential.json", json_encode($data));
}

function getCredential() {
    if (!file_exists("credential.json")) return null;
    return json_decode(file_get_contents("credential.json"), true);
}
