<?php
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    //인증 실패
    $server->getResponse()->send();
    die;
}

?>