<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');

/*
  Delete Inquiry API
  2020-10-17 goraegori
  Input : faq_id
  Output : success, message
*/

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");
$datetime = date("Y-m-d H:i:s");

try{
  if(!$cadre_flag) throw new Exception("간부만 접근할 수 있습니다");
  if(empty($input['inquiry_id'])) throw new Exception("문의 아이디를 입력하지 않았습니다");
  
  $sql = "SELECT * FROM inquiry WHERE inquiry_id=$input[inquiry_id]"; 
  $result = mysqli_query($dbconn,$sql);
  $row=mysqli_fetch_assoc($result);
  
  if(!$result->num_rows) throw new Exception("존재하지 않는 문의입니다");
  if(!$admin_flag && $userInfo['user_id'] !== $row['user_id']) throw new Exception("관리자 혹은 작성자만 접근할 수 있습니다");
  
  $sql = "DELETE FROM inquiry WHERE inquiry_id=$input[inquiry_id]"; 
  $result = mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>