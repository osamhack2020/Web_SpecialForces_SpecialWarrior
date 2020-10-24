<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

/*
  get user unit_id Function
  2020-10-21 goraegori
  Input : user_id
  Output : unit_id
*/

function get_user_unit_id($dbconn,$user_id){
  try{
    
    $sql = "SELECT unit_id FROM warrior WHERE user_id = '$user_id';";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row['unit_id'];
  }
  catch(Exception $e){
    http_response_code(400); //bad request
    return;
  }
}
?>