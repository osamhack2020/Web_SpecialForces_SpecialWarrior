<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

/*
  Get User Name Function
  2020-10-xx goraegori
  Input : user_id
  Output : name
*/

function get_user_name($dbconn,$user_id){
  try{
    $sql = "SELECT name FROM warrior WHERE user_id = '$user_id';";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row['name'];
  }
  catch(Exception $e){
    http_response_code(400); //bad request
    return "Function Error";
  }
}
?>