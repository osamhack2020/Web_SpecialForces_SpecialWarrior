<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('./get_profile_function.php');

$input = json_decode(file_get_contents('php://input'),true);

$input['date']= $input['date']?$input['date']:'';
$res = get_profile($dbconn,$userInfo['user_id'],$input['date']);
echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>