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
  if(empty($input['question']) || empty($input['answer'])) throw new Exception("질문이나 응답이 입력되지 않았습니다");
  
  $sql = "INSERT INTO faq(question,answer) VALUES('$input[question]','$input[answer]')"; 
  $result = mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>