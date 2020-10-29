<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('./cadre_validator.php');
require_once('../profile/get_calorie_data_function.php');
require_once('./get_accessible_unit_function.php');

/*
  Get Calorie Data Of ALL API
  2020-10-29 goraegori
  Input : unit_id
  Output : {success,result({profile_id,date,weight},...),min_max_avg(min,max,average)},...
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
    if(empty($input['date'])){
      $calorie_data=get_calorie_data($dbconn,$row['user_id']);
    }
    else{
      $calorie_data=get_calorie_data_of_date($dbconn,$row['user_id'],$input['date']);
    }
    $calorie_data['name'] = $row['name'];
    array_push($res,$calorie_data);
  }
  
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}
echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>