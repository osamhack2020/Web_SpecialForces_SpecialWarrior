<?php
// include our OAuth2 Server object
require_once __DIR__.'/settings.php';

// Handle a request for an OAuth2.0 Access Token and send the response to the client
$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
// $token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
// print_r($token);
?>