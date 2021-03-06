<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('./get_heartrate_profile_data_function.php');

/*
  Get Sleeptime Data Function
  2020-10-23 goraegori
  Input : 
  Output : success,result({date, result({profile_id,date,sleep_time},...),min_max_avg(min,max,average)}, ...)
*/

$input = json_decode(file_get_contents('php://input'),true);

//일별로, 30일치 데이터
$date=date("Y-m-d");

try{
  $res = get_heartrate_profile_data($dbconn,$userInfo['user_id']);
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>