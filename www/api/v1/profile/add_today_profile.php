<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');

function add_today_profile($dbconn, $user_id){
  $res=array("success"=>false,"message"=>"");
  $date = date("Y-m-d");
  try{
    // Check if profile of the date exists.
    $sql = "SELECT * FROM day_profile WHERE user_id='$user_id' AND date='$date';";
    $result = mysqli_query($dbconn,$sql);
    $cnt = $result->num_rows;
    if($cnt)
      throw new Exception("already existing");
    
    $sql = "INSERT INTO day_profile(user_id,date) VALUES('$user_id','$date');";
    mysqli_query($dbconn,$sql);
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