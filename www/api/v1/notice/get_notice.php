<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('../member/get_user_name_function.php');


/*
  Get Notice API
  2020-10-17 goraegori
  Input : unit_id
  Output : success,result(notice_id,unit_id,user_id,subject,content,created_at,modified_at)
*/
$res=array("success"=>false,"result"=>array());
$input = json_decode(file_get_contents('php://input'),true);

try{
  if(empty($input['unit_id'])) $input['unit_id']=$userInfo['unit_id'];
  
  $sql = "SELECT * FROM notice WHERE unit_id=$input[unit_id]";
  $result = mysqli_query($dbconn,$sql);
  while($row = mysqli_fetch_assoc($result)){
     $row['name'] = get_user_name($dbconn,$userInfo['user_id']);
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