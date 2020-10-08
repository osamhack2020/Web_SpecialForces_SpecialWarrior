<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"result"=>array("requested"=>array(),"friend"=>array()));

try{ 
  $sql = "SELECT me as user_id FROM comrade WHERE comrade='$userInfo[user_id]' AND accepted = 0;"; //opponent -> me (not accepted yet)
  $result = mysqli_query($dbconn,$sql);
  for($i=0;$i<$result->num_rows;$i++){
    $row = mysqli_fetch_assoc($result);
    
    array_push($res['result']['requested'], $row);
  }
  $sql = "SELECT comrade as user_id FROM comrade WHERE me='$userInfo[user_id]' AND accepted = 1;";
  $result = mysqli_query($dbconn,$sql);
  for($i=0;$i<$result->num_rows;$i++){
    $row = mysqli_fetch_assoc($result);
    array_push($res['result']['friend'], $row);
  }
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res);
?>