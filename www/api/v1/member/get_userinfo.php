<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('./get_unitname_function.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"result"=>array());

try{
  $userInfo['unit_name'] = get_unitname($dbconn,$userInfo['unit_id'])['result'][0];
  array_push($res['result'], $userInfo);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>