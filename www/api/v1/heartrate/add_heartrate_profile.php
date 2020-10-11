<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('../profile/get_today_profile_id.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");
$date = date("Y-m-d H:i:s"); 
try{
  if(empty($input['heartrate'])){
    throw new Exception("입력 된 기록이 없습니다");
  }
  
  $today_profile_id = get_today_profile_id($dbconn,$token)['result'][0]['profile_id'];
  //add heartrate profile
  $sql = "INSERT INTO heartrate_profile(heartrate,profile_id,user_id,created_at) VALUES($input[heartrate],$today_profile_id,'$userInfo[user_id]','$date');";
  mysqli_query($dbconn,$sql);
  
  //get heartrate average for the day
  $sql = "SELECT CAST(AVG(heartrate) as UNSIGNED) as average FROM heartrate_profile WHERE profile_id=$today_profile_id";
  $result = mysqli_query($dbconn,$sql);
  $heartrate_average = mysqli_fetch_assoc($result)['average'];
  
  //update average heartrate to daily profile 
  $sql = "UPDATE day_profile SET heartrate_average = $heartrate_average WHERE profile_id=$today_profile_id";
  $result = mysqli_query($dbconn,$sql);
  
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>