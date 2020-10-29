<?php

/*
  Get Weight Data Function
  2020-10-24 goraegori
  Input : user_id
  Output : success,result({profile_id,user_id,date,weight},...),min_max_avg(min,max,average)
*/
// 일별로, 30일치
function get_weight_data($dbconn,$user_id){
  // 일별로, 30일치
  $res=array("success"=>false,"result"=>array(),"min_max_avg"=>array());
  $date = date("Y-m-d");
  
  $fromDate = date("Y-m-d",strtotime($date." -30 days"));
  $toDate = $date;

try{
  //GET AVERAGE
  $sql = "SELECT CAST(MIN(weight) as UNSIGNED) as min,CAST(MAX(weight) as UNSIGNED) as max,CAST(AVG(weight) as UNSIGNED) as average FROM day_profile WHERE user_id = '$user_id' AND date between '$fromDate' and '$toDate';";
  $result = mysqli_query($dbconn,$sql);
  $row = mysqli_fetch_assoc($result);
  $res['min_max_avg']= $row;
  
  //GET ALL RESULTS
  $sql = "SELECT profile_id,date,weight FROM day_profile WHERE user_id = '$user_id' AND date between '$fromDate' and '$toDate';";
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

function get_weight_data_of_date($dbconn,$user_id,$date){
  // 일별로, 30일치
  $res=array("success"=>false,"result"=>array(),"min_max_avg"=>array());

try{
  //GET AVERAGE
  $sql = "SELECT CAST(MIN(weight) as UNSIGNED) as min,CAST(MAX(weight) as UNSIGNED) as max,CAST(AVG(weight) as UNSIGNED) as average FROM day_profile WHERE user_id = '$user_id' AND date = '$date';";
  $result = mysqli_query($dbconn,$sql);
  $row = mysqli_fetch_assoc($result);
  $res['min_max_avg']= $row;
  
  //GET ALL RESULTS
  $sql = "SELECT profile_id,date,weight FROM day_profile WHERE user_id = '$user_id' AND date = '$date';";
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