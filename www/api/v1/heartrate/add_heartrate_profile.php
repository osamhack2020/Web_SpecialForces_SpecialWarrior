<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('../profile/get_today_profile_id.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");
$date = date("Y-m-d H:i:s"); 
try{
  /* // Check if profile of the date exists.
  $sql = "SELECT * FROM day_profile WHERE user_id='$token[user_id]' AND date='$input[date]';";
  $result = mysqli_query($dbconn,$sql);
  $cnt = $result->num_rows;
  if( !$cnt ){
    // profile of date does not exist.
    include_once('../profile/add.php');
    add_profile($db_conn, $token, $input_for_profile, true);
  } */
  if(empty($input['exercise_weight']) && empty($input['exercise_count']) && empty($input['exercise_time'])){
    throw new Exception("입력 된 기록이 없습니다");
  }
  
  $today_profile_id = get_today_profile_id($dbconn,$token)['result'][0]['profile_id'];
  $sql = "INSERT INTO exercise_profile(exercise_id,exercise_weight,exercise_count,exercise_time,profile_id,user_id) VALUES($input[exercise_id],$input[exercise_weight],$input[exercise_count],$input[exercise_time],$today_profile_id,'$userInfo[user_id]');";
  mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>