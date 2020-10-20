<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');
require_once('./get_accessible_unit_function.php');

/*
  Delete Notice API
  2020-10-17 goraegori
  Input : notice_id
  Output : success, message
*/

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");
$datetime = date("Y-m-d H:i:s");

try{
  if(!$cadre_flag) throw new Exception("간부만 접근할 수 있습니다");
  if(empty($input['notice_id'])) throw new Exception("공지 아이디를 입력하지 않았습니다");
  
  //Get Notice unit_id and validate
  $sql = "SELECT unit_id FROM notice WHERE notice_id=$input[notice_id]"; 
  $result = mysqli_query($dbconn,$sql);
  if(!$result->num_rows) throw new Exception("존재하지 않는 공지입니다");
  $row=mysqli_fetch_assoc($result);
  if( !in_array( $row['unit_id'],get_accessible_unit($dbconn,$userInfo['user_id']) ) ) throw new Exception("접근할 수 없는 소속입니다");
  
  $sql = "DELETE FROM notice WHERE notice_id=$input[notice_id]"; 
  $result = mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>