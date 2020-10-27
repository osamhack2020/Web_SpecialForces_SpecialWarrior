<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('../profile/get_today_profile_id.php');


/*
  Add Exercise Profile API
  2020-10-xx goraegori
  Input : exercise_weight, exercise_count, exercise_time
  Output : success, message
*/

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");
$date = date("Y-m-d"); 
try{
  if(empty($input['exercise_weight']) && empty($input['exercise_count']) && empty($input['exercise_time'])){
    throw new Exception("입력 된 기록이 없습니다");
  }
  
  $today_profile_id = get_today_profile_id($dbconn,$token)['result'][0]['profile_id'];
  $sql = "INSERT INTO exercise_profile(exercise_id,exercise_weight,exercise_count,exercise_time,profile_id,user_id,created_at) VALUES($input[exercise_id],$input[exercise_weight],$input[exercise_count],$input[exercise_time],$today_profile_id,'$userInfo[user_id]','$date');";
  mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>