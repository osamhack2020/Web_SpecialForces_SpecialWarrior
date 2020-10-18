<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('../member/get_user_name_function.php');

$res=array("success"=>false,"result"=>array());
/*
  Get Notice API
  2020-10-17 goraegori
  Input : 
  Output : success,result(notice_id,unit_id,user_id,subject,content,created_at,modified_at)
*/
try{
  $sql = "SELECT * FROM notice WHERE unit_id=$userInfo[unit_id]";
  $result = mysqli_query($dbconn,$sql);
  while($row = mysqli_fetch_assoc($result)){
     $row['name'] = get_user_name($dbconn,$userInfo['user_id'])['result'][0]['name'];
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