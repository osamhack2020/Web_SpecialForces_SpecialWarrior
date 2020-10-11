<?php

function get_heartrate_profile_by_date($dbconn,$date,$userInfo){
  
  $res=array("date"=>$date,"result"=>array(),"min_max_avg"=>array());
  try{
    
    //GET OVERALL AVERAGE FROM DATE
    $sql = "
    SELECT CAST(MIN(heartrate) as UNSIGNED) as min,CAST(MAX(heartrate) as UNSIGNED) as max,CAST(AVG(heartrate) as UNSIGNED) as average 
    FROM heartrate_profile 
    WHERE user_id = '$userInfo[user_id]' AND created_at between '$date 00:00:00' AND '$date 23:59:59';
    ";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    array_push($res['min_max_avg'], $row);
    
    $sql = "
    SELECT *
    FROM heartrate_profile
    WHERE user_id='$userInfo[user_id]' AND created_at between '$date 00:00:00' AND '$date 23:59:59';
    "; 
    $result = mysqli_query($dbconn,$sql);
    for($i=0;$i<$result->num_rows;$i++){
      $row = mysqli_fetch_assoc($result);
      array_push($res['result'], $row);
    }
  }
  catch(Exception $e){
    http_response_code(400); //bad request
    $res['message'] = $e->getMessage();
  }

  return $res;
}
?>