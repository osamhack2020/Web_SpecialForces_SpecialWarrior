<?php
require_once('../dbsettings.php');
require_once('../profile/add_today_profile.php');

// OAuth2\Storage\UserCredentialsInterface 에서 DB 형태에 따라 수정
$input = json_decode(file_get_contents('php://input'),true);

$res=array("success"=>false,"message"=>"");
$inputs_list=array("user_id"=>"아이디","password"=>"패스워드","army_num"=>"군번","name"=>"이름","unit_id"=>"소속","email"=>"이메일","phone"=>"전화번호");

try{
  // no empty inputs(some can be empty)
  foreach($inputs_list as $key => $translate ){
    if(empty($input[$key]))
      throw new Exception($translate."은(는) 공백일 수 없습니다");
  }
  
  // no username overlaps
  $sql = "SELECT count(*) as cnt FROM $warriors_table WHERE user_id='$input[user_id]';";
  $result = mysqli_query($dbconn,$sql);
  $row = mysqli_fetch_assoc($result);
  if($row['cnt'])
    throw new Exception("사용할 수 없는 아이디입니다");
  
  // no email overlaps
  $sql = "SELECT count(*) as cnt FROM $warriors_table WHERE email='$input[email]';";
  $result = mysqli_query($dbconn,$sql);
  $row = mysqli_fetch_assoc($result);
  if($row['cnt'])
    throw new Exception("사용할 수 없는 이메일입니다");
  
  // user can only select unit_id that exists
  $sql = "SELECT unit_id FROM unit WHERE unit_id = $input[unit_id]";
  $result = mysqli_query($dbconn,$sql);
  if($result->num_rows == 0)
    throw new Exception("사용 할 수 없는 소속(부대)입니다");
  
  // able to skip unnecessary fields
   if(!$input['cadre_flag'])
    $input['cadre_flag'] = 0;
  if(!isset($input['cadre_flag']))
    $input['cadre_flag'] = 0;
  if(!isset($input['class']))
    $input['class'] = 0;
  
  $date = date("Y-m-d H:i:s"); 
  // register user
  $encrypted_pass = sha1($input['password']);
  $sql = "INSERT INTO $warriors_table VALUES('$input[user_id]','$encrypted_pass',$input[cadre_flag],0,NULL,$input[class],
  '$input[army_num]',$input[unit_id],'$input[name]','$input[email]','$input[phone]','$date','$date')";
  mysqli_query($dbconn,$sql);
  add_today_profile($dbconn,$input['user_id']);
  $res['success']=true;
  $res['message']="회원가입 성공";
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res,JSON_UNESCAPED_UNICODE);
?>