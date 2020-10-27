<?php

/*
  Get Daily Profile Function
  2020-10-?? goraegori
  Input : user_id, date(*optional)
  Output : success,result(profile_id,user_id,date,weight,height,calorie,sleep_time,heartrate_average)
*/

function get_profile($dbconn,$user_id,$date){
  $res=array("success"=>false,"result"=>array());
  try{
    if(empty($date))
      $date = date("Y-m-d");
    
    $sql = "SELECT * FROM day_profile WHERE user_id = '$user_id' AND date = '$date';";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    $res['result']= $row;
    $res['success']=true;
  }
  catch(Exception $e){
    http_response_code(400); //bad request
    $res['message'] = $e->getMessage();
  }
  return $res;
}
?>