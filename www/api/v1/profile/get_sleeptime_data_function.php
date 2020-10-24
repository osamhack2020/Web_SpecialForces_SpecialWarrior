<?php
/*
  Get Sleeptime Data Function
  2020-10-23 goraegori
  Input : 
  Output : success,result({profile_id,date,sleep_time},...),min_max_avg(min,max,average)
*/

function get_sleeptime_data($dbconn,$user_id){
  // 일별로, 30일치
  $res=array("success"=>false,"result"=>array(),"min_max_avg"=>array());
  $date = date("Y-m-d");
  
  $fromDate = date("Y-m-d",strtotime($date." -30 days"));
  $toDate = $date;
  
  try{
    //GET AVERAGE
    $sql = "SELECT CAST(MIN(sleep_time) as UNSIGNED) as min,CAST(MAX(sleep_time) as UNSIGNED) as max,CAST(AVG(sleep_time) as UNSIGNED) as average FROM day_profile WHERE user_id = '$user_id' AND date between '$fromDate' and '$toDate';";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    $res['min_max_avg']= $row;
    
    //GET ALL RESULTS
    $sql = "SELECT profile_id,date,sleep_time FROM day_profile WHERE user_id = '$user_id' AND date between '$fromDate' and '$toDate';";
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
  return $res;
}
?>