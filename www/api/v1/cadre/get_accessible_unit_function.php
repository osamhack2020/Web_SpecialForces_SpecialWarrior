<?php
/*
  Get Accessible Unit Function
  2020-10-17 goraegori
  Input : user_id
  Output : array(unit_id)
*/

function get_accessible_unit($dbconn,$user_id){
  $res=null;
  try{
    $sql = "SELECT admin_privilege FROM warrior WHERE user_id = '$user_id'"; //Except cadre, only shows soldiers on same unit.
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    $array_accessible_split=explode('|',$row['admin_privilege']);
    $res= $array_accessible_split;
  }
  catch(Exception $e){
    http_response_code(400); //bad request
    $res['message'] = $e->getMessage();
  }
  
  return $res;
}
?>