<?php
require_once __DIR__.'/../auth/settings.php';

// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    //인증 실패
    $server->getResponse()->send();
    die;
}
echo json_encode(array('success' => true, 'message' => 'API 접근 성공!'));

?>