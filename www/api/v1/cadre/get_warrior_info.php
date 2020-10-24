<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');
require_once('../member/get_user_unit_id_function.php');
require_once('../profile/get_profile_function.php');
require_once('../profile/get_latest_examine_data_function.php');
require_once('./get_accessible_unit_function.php');

/*
  Get Warrior Info API
  2020-10-21 goraegori
  Input : user_id
  Output : success, result(warrior userInfo, latest_examine_data, today_profile)
*/

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"result"=>array());

try{
  if(!$cadre_flag) throw new Exception("간부만 접근할 수 있습니다");
  if(empty($input['user_id'])) throw new Exception("유저 아이디가 입력되지 않았습니다");
  if( !in_array( get_user_unit_id($dbconn,$input['user_id']),get_accessible_unit($dbconn,$userInfo['user_id']) ) ) throw new Exception("접근할 수 없는 소속입니다");
  
  $info = $storage->getUserInfo($input['user_id']);
  $info['today_profile'] = get_profile($dbconn,$input['user_id'],null)['result']; //Today
  $info['latest_examine_data'] = get_latest_examine_data($dbconn,$input['user_id'])['result'];
  array_push($res['result'], $info);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>