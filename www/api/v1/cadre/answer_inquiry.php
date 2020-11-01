<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');

/*
  Write FAQ API
  2020-10-17 goraegori
  Input : unit_id,subject,content
  Output : success, message
*/

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");
$datetime = date("Y-m-d H:i:s");

try{
  if(!$cadre_flag) throw new Exception("간부만 접근할 수 있습니다");
  if(!$admin_flag) throw new Exception("관리자만 접근할 수 있습니다");
  if(empty($input['inquiry_id'])) throw new Exception("응답 대상이 없습니다");
  if(empty($input['answer_subject']) || empty($input['answer_content']) ) throw new Exception("응답이 입력되지 않았습니다");
  
  $sql = "SELECT * FROM inquiry WHERE inquiry_id=$input[inquiry_id]"; 
  $result = mysqli_query($dbconn,$sql);
  if(!$result->num_rows) throw new Exception("존재하지 않는 문의입니다");
  
  $sql = "UPDATE inquiry SET answer_subject='$input[answer_subject]',answer_content='$input[answer_content]',admin_user_id='$userInfo[user_id]',state='응답 완료' WHERE inquiry_id=$input[inquiry_id]";
  $result = mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>