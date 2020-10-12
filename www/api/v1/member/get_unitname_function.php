<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

function get_unitname($dbconn,$unit_id){
  $res=array("success"=>false,"result"=>array());
  try{
    
    $sql = "SELECT unit_name,battalion,company,platoon,department FROM unit WHERE unit_id = '$unit_id';";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result); 
    $unitname="";
    foreach($row as $key=>$value){
      $unitname = $unitname.$value.' ';
    }
    array_push($res['result'], $unitname);
    $res['success']=true;
  }
  catch(Exception $e){
    http_response_code(400); //bad request
    $res['message'] = $e->getMessage();
  }
  return $res;
}
?>