<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');
require_once('../profile/get_latest_examine_data_function.php');
require_once('./get_accessible_unit_function.php');

/*
  Get Grade Data Of ALL API
  2020-10-27 goraegori
  Input : unit_id
  Output : {success,result({name,grade},...),,...
*/
$input = json_decode(file_get_contents('php://input'),true);

$res=array();
try{
  if(!$cadre_flag) throw new Exception("간부만 접근할 수 있습니다");
  if(empty($input['unit_id'])) $input['unit_id']=$userInfo['unit_id'];
  if( !in_array( $input['unit_id'],get_accessible_unit($dbconn,$userInfo['user_id']) ) ) throw new Exception("접근할 수 없는 소속입니다");
  
  $sql = "SELECT user_id,name FROM warrior WHERE user_id != '$userInfo[user_id]' AND unit_id = $input[unit_id] AND cadre_flag=0;"; //Except cadre, only shows soldiers on same unit.
  $result = mysqli_query($dbconn,$sql);
  for($i=0;$i<$result->num_rows;$i++){
    $row = mysqli_fetch_assoc($result);
    $grade_data['grade']=get_latest_examine_data($dbconn,$row['user_id'])['result']['grade'];
    $grade_data['name'] = $row['name'];
    array_push($res,$grade_data);
  }
  
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}
echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>