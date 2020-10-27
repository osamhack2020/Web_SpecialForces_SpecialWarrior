<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');
require_once('../profile/get_weight_data_function.php');

/*
  Get Sleeptime Data API
  2020-10-?? goraegori
  Input : user_id
  Output : success,result({profile_id,date,sleep_time},...),min_max_avg(min,max,average)
*/
$input = json_decode(file_get_contents('php://input'),true);

try{
  if(!$cadre_flag) throw new Exception("간부만 접근할 수 있습니다");
  if(empty($input['user_id'])) throw new Exception("유저 아이디가 입력되지 않았습니다");
  $res = get_weight_data($dbconn,$input['user_id']);
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}
echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>