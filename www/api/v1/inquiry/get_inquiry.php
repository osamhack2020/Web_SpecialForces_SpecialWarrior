<?php
require_once __DIR__.'/../auth/settings.php';
require_once('../dbsettings.php');
require_once('../token_validator.php');
require_once('../cadre/cadre_validator.php');

/*
  Get Faq API
  2020-10-17 goraegori
  Input : 
  Output : success,result(faq_id,question,answer)
*/
$res=array("success"=>false,"result"=>array());

try{
  if($admin_flag)
    $sql = "SELECT * FROM inquiry";
  else
    $sql = "SELECT * FROM inquiry WHERE user_id = '$userInfo[user_id]'";
  $result = mysqli_query($dbconn,$sql);
  while($row = mysqli_fetch_assoc($result)){
     array_push($res['result'], $row); 
  }
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>