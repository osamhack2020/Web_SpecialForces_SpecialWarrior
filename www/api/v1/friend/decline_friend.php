<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');

$input = json_decode(file_get_contents('php://input'),true);
$res=array("success"=>false,"message"=>"");

try{
  if(empty($input['target']))
    throw new Exception("대상이 입력되지 않았습니다");
  
  //DELETE REQUEST
  $sql = "DELETE FROM comrade WHERE me='$input[target]' AND comrade='$userInfo[user_id]'; "; // me is opponent(requester)
  $result = mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>