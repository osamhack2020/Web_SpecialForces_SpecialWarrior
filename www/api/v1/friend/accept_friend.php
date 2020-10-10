<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");

try{
  if(empty($input['target']))
    throw new Exception("대상이 입력되지 않았습니다");
  
  //check request
  $sql = "SELECT * FROM comrade WHERE comrade = '$userInfo[user_id]' AND me = '$input[target]' AND accepted = 0";
  $result = mysqli_query($dbconn,$sql);
  $cnt = $result->num_rows;
  if(!$cnt)
    throw new Exception("그런 요청은 없습니다");
  
  // ACCEPT REQUEST
  $sql = "UPDATE comrade SET accepted = 1 WHERE me='$input[target]' AND comrade='$userInfo[user_id]'; "; //me is requester
  $result = mysqli_query($dbconn,$sql);
  
  // ADD OPPOSITE RELATION
  $sql = "INSERT INTO comrade(me, comrade, accepted) VALUES('$userInfo[user_id]','$input[target]',1); ";
  $result = mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>