<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('get_heartrate_profile_by_date_function.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"result"=>array());

//어떤 날짜에 입력된 heartrate profile만
try{
  if(empty($input['date'])){
    $input['date']=date("Y-m-d");
  }
  $result = get_heartrate_profile_by_date($dbconn,$input['date'],$userInfo);
  array_push($res['result'],$result);
  $res['success'] = true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>