<?php
require_once __DIR__.'/../auth/settings.php';
include_once('../dbsettings.php');
include_once('../token_validator.php');

$input = json_decode(file_get_contents('php://input'),true);
$token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
$res=array("success"=>false,"result"=>array());

try{ 
  $sql = "SELECT user_id,class,army_num,unit_id,email,phone,created_at FROM warrior WHERE user_id='$token[user_id]';";
  $result = mysqli_query($dbconn,$sql);
  $row = mysqli_fetch_assoc($result);
  array_push($res['result'], $row);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res);
?>