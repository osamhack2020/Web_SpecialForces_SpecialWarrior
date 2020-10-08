<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");

try{
  //check self-to-self request
  if($token['user_id'] === $input['target'])
    throw new Exception("자신은 추가할 수 없습니다");
  
  //check overlap
  $sql = "SELECT * FROM comrade WHERE me = '$userInfo[user_id]' AND comrade = '$input[target]'";
  $result = mysqli_query($dbconn,$sql);
  $cnt = $result->num_rows;
  if($cnt)
    throw new Exception("이미 요청되었습니다");
  
  //check existance
  $sql = "SELECT user_id FROM warrior WHERE user_id = '$input[target]'";
  $result = mysqli_query($dbconn,$sql);
  $cnt = $result->num_rows;
  if(!$cnt)
    throw new Exception("그런 대상은 없습니다");
  
  if(empty($input['target']))
    throw new Exception("대상이 입력되지 않았습니다");
  
  $sql = "INSERT INTO comrade(me, comrade) VALUES('$userInfo[user_id]','$input[target]')";
  $result = mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res);
?>