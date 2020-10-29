<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

/*
  Get Exercise Ids API
  Shows every exercise type that exists
  2020-10-xx goraegori
  Input : 
  Output : success, resykt
*/


$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"result"=>array());

try{ 
  $sql = "SELECT * FROM exercise_type;";
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

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>