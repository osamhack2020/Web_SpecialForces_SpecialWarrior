<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');
require_once('./get_accessible_unit_function.php');

/*
  Write Notice API
  2020-10-17 goraegori
  Input : unit_id,subject,content
  Output : success, message
*/

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");
$datetime = date("Y-m-d H:i:s");

try{
  if(!$cadre_flag) throw new Exception("간부만 접근할 수 있습니다");
  if(empty($input['subject']) || empty($input['content'])) throw new Exception("제목이나 내용이 입력되지 않았습니다");
  if(empty($input['unit_id'])) $input['unit_id']=$userInfo['unit_id'];
  if( !in_array( $input['unit_id'],get_accessible_unit($dbconn,$userInfo['user_id']) ) ) throw new Exception("접근할 수 없는 소속입니다");
  
  $sql = "INSERT INTO notice(unit_id,user_id,subject,content,created_at,modified_at) VALUES($input[unit_id],'$userInfo[user_id]','$input[subject]','$input[content]','$datetime','$datetime')"; 
  $result = mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>