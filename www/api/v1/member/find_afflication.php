<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"result"=>array());

//input : {substring}

//output : {unit_name, unit_id}

try{
  $sql = "SELECT unit_full_name,unit_id FROM unit WHERE unit_full_name LIKE '%$input[substring]%'";
  $result = mysqli_query($dbconn,$sql);
  while($row = mysqli_fetch_assoc($result)){
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