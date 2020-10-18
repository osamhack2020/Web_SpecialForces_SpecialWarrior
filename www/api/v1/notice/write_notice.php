<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('../member/get_user_name_function.php');

/*
  Write Notice API
  2020-10-17 goraegori
  Input : subject, content
  Output : success,message
*/
$res=array("success"=>false,"message"=>array());
$input = json_decode(file_get_contents('php://input'),true);
$datetime = date("Y-m-d H:i:s");

try{
  $sql = "INSERT INTO notice(unit_id,user_id,subject,content,created_at,modified_at) VALUES($userInfo[unit_id],'$userInfo[user_id]','$input[subject]','$input[content]','$datetime','$datetime')";
  $result = mysqli_query($dbconn,$sql);
  
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>