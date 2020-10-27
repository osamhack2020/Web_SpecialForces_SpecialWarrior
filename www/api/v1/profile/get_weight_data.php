<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('./get_weight_data_function.php');

/*
  Get Weight Data API
  2020-10-?? goraegori
  Input : 
  Output : success,result({profile_id,user_id,date,weight},...),min_max_avg(min,max,average)
*/

try{
  $res = get_weight_data($dbconn,$userInfo['user_id']);
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}
echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>