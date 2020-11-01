<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');

/*
  SET INQUIRY STATE API
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
  if(empty($input['inquiry_id'])) throw new Exception("대상이 없습니다");
  if(empty($input['state']) ) throw new Exception("상태가 입력되지 않았습니다");
  
  $sql = "SELECT * FROM inquiry WHERE inquiry_id=$input[inquiry_id]"; 
  $result = mysqli_query($dbconn,$sql);
  if(!$result->num_rows) throw new Exception("존재하지 않는 문의입니다");
  
  $sql = "UPDATE inquiry SET state='$input[state]' WHERE inquiry_id='$input[inquiry_id]')";
  $result = mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>