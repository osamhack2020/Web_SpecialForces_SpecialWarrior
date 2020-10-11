<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('get_heartrate_profile_by_date_function.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"result"=>array());

//일별로, 30일치 데이터
$date=date("Y-m-d");


try{
  for($i=0;$i<=30;$i++){
    $queryDate = date("Y-m-d",strtotime($date." -$i days"));
    $result = get_heartrate_profile_by_date($dbconn,$queryDate,$userInfo);
    if(!empty($result['result']))
      array_push($res['result'],$result);
  }
  
  $res['success'] = true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

// try{ 
//   //GET OVERALL AVERAGE 
//   $sql = "SELECT CAST(MIN(heartrate) as UNSIGNED) as min,CAST(MAX(heartrate) as UNSIGNED) as max,CAST(AVG(heartrate) as UNSIGNED) as average FROM heartrate_profile WHERE user_id = '$token[user_id]' AND date between '$fromDate' and '$toDate';";
//   $result = mysqli_query($dbconn,$sql);
//   $row = mysqli_fetch_assoc($result);
//   array_push($res['min_max_avg'], $row);
  
//   $sql = "SELECT * FROM heartrate_profile WHERE user_id=$userInfo[user_id] AND date between '$fromDate' and '$toDate';"; 
//   $result = mysqli_query($dbconn,$sql);
//   for($i=0;$i<$result->num_rows;$i++){
//     //TODO: get average computed for each day
//     $row = mysqli_fetch_assoc($result);
//     array_push($res['result'], $row);
//   }
//   $res['success']=true;
// }
// catch(Exception $e){
//   http_response_code(400); //bad request
//   $res['message'] = $e->getMessage();
// }

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>