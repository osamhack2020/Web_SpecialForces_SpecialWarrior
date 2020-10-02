<?php
require_once __DIR__.'/../auth/settings.php';
include_once('../dbsettings.php');
include_once('../token_validator.php');

function add_profile($dbconn, $token, $input, $exit_without_echo){
  $res=array("success"=>false,"message"=>"");
  $date = date("Y-m-d");
  try{
    // Check if profile of the date exists.
    $sql = "SELECT * FROM day_profile WHERE user_id='$token[user_id]' AND date='$input[date]';";
    $result = mysqli_query($dbconn,$sql);
    $cnt = $result->num_rows;
    if($cnt)
      throw new Exception("$input[date]의 프로필은 이미 있습니다.");
    
    $sql = "INSERT INTO day_profile(user_id,date,weight,height,calorie,sleep_time) VALUES('$token[user_id]','$input[date]',$input[weight],$input[height],$input[calorie],$input[sleep_time]);";
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

$input = json_decode(file_get_contents('php://input'),true);
$token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());

echo json_encode( add_profile($dbconn, $token,$input, false) );
?>