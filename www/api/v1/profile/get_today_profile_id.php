<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

function get_today_profile_id($dbconn, $token){
  $res=array("success"=>false,"result"=>array());
  $date = date("Y-m-d");
  try{
    
    $sql = "SELECT profile_id FROM day_profile WHERE user_id = '$token[user_id]' AND date = '$date';";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    array_push($res['result'], $row);
    $res['success']=true;
  }
  catch(Exception $e){
    http_response_code(400); //bad request
    $res['message'] = $e->getMessage();
  }
  //if($exit_without_echo) exit(0);
  return $res;
}
?>