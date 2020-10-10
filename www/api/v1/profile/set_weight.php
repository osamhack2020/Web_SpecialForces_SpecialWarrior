<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('./get_today_profile_id.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");

try{
  if(empty($input['weight']))
    throw new Exception("체중이 입력되지 않았습니다");
  
  $today_profile_id = get_today_profile_id($dbconn,$token)['result'][0]['profile_id'];
  
  // UPDATE DATA
  $sql = "UPDATE day_profile SET weight=$input[weight] WHERE user_id = '$userInfo[user_id]' AND profile_id=$today_profile_id; ";
  mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>