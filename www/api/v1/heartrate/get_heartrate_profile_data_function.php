<?php
require_once('get_heartrate_profile_by_date_function.php');
/*
  Get Sleeptime Data Function
  2020-10-23 goraegori
  Input : 
  Output : success,result({date, result({profile_id,date,sleep_time},...),min_max_avg(min,max,average)}, ...)
*/
function get_heartrate_profile_data($dbconn,$user_id,$skip_empty=true){
  $res=array("success"=>false,"result"=>array());
  
  //일별로, 30일치 데이터
  $date=date("Y-m-d");
  $fromDate = date("Y-m-d",strtotime($date." -30 days"));
  try{
    for($i=30;$i>=0;$i--){
      $queryDate = date("Y-m-d",strtotime($date." -$i days"));
      $result = get_heartrate_profile_by_date($dbconn,$queryDate,$user_id);
      if($skip_empty && empty($result['result']))
        continue;
      array_push($res['result'],$result);
    }
    
    $sql = "
    SELECT CAST(MIN(heartrate) as UNSIGNED) as min,CAST(MAX(heartrate) as UNSIGNED) as max,CAST(AVG(heartrate) as UNSIGNED) as average 
    FROM heartrate_profile
    WHERE user_id = '$user_id' AND created_at between '$fromDate 00:00:00' AND '$date 23:59:59';
    ";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    $res['min_max_avg']=$row;
    
    $res['success'] = true;
  }
  catch(Exception $e){
    http_response_code(400); //bad request
    $res['message'] = $e->getMessage();
  }
  
  return $res;
}
?>