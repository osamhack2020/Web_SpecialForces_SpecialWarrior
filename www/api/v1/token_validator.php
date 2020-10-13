<?php
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    //인증 실패
    $server->getResponse()->send();
    die;
}
$token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
$userInfo = $storage->getUserInfo($token['user_id']);
?>