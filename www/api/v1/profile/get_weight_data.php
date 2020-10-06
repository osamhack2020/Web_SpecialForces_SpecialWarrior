<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

$input = json_decode(file_get_contents('php://input'),true);
$token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
// 일별로, 30일치
$res=array("success"=>false,"result"=>array(),"min_max_avg"=>array());
$date = date("Y-m-d");

$fromDate = date("Y-m-d",strtotime($date." -30 days"));
$toDate = $date;

try{
  //GET AVERAGE
  $sql = "SELECT CAST(MIN(weight) as UNSIGNED) as min,CAST(MAX(weight) as UNSIGNED) as max,CAST(AVG(weight) as UNSIGNED) as average FROM day_profile WHERE user_id = '$token[user_id]' AND date between '$fromDate' and '$toDate';";
  $result = mysqli_query($dbconn,$sql);
  $row = mysqli_fetch_assoc($result);
  array_push($res['min_max_avg'], $row);
  //GET ALL RESULTS
  $sql = "SELECT profile_id,date,weight FROM day_profile WHERE user_id = '$token[user_id]' AND date between '$fromDate' and '$toDate';";
  $result = mysqli_query($dbconn,$sql);
  for($i=0;$i<$result->num_rows;$i++){
    $row = mysqli_fetch_assoc($result);
    array_push($res['result'], $row);
  }
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}
echo json_encode($res);
?>