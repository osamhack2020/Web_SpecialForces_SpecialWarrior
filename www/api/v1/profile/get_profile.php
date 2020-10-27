<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('./get_profile_function.php');

/*
  Get Daily Profile API
  2020-10-?? goraegori
  Input :  date(*optional)
  Output : success,result(profile_id,user_id,date,weight,height,calorie,sleep_time,heartrate_average)
*/
$input = json_decode(file_get_contents('php://input'),true);

$input['date']= $input['date']?$input['date']:null;
$res = get_profile($dbconn,$userInfo['user_id'],$input['date']);
echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>