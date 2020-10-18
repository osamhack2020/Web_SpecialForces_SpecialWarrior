<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');
require_once('../member/get_unitname_function.php');
require_once('./get_accessible_unit_function.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"result"=>array());

try{
  if(!$cadre_flag) throw new Exception("간부만 접근할 수 있습니다");
  $array_accessible_split=get_accessible_unit($dbconn,$userInfo['user_id']);
  $array_accessible=array();
  foreach($array_accessible_split as $value){
    array_push($array_accessible, get_unitname($dbconn,$value)['result'][0]);
  }
  array_push($res['result'], $array_accessible);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>