<?php
include_once('../dbsettings.php');

//header('Access-Control-Allow-Origin: *'); header('Access-Control-Allow-Headers: Content-Type, X-Requested-With'); header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT'); header('Access-Control-Max-Age: 600');

// OAuth2\Storage\UserCredentialsInterface 에서 DB 형태에 따라 수정
$input = json_decode(file_get_contents('php://input'),true);

$res=array("success"=>false,"message"=>"");
$inputs_list=array("user_id"=>"아이디","password"=>"패스워드","army_num"=>"군번","unit_id"=>"소속","email"=>"이메일","phone"=>"전화번호");

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
  
  
  // register user
  $encrypted_pass = sha1($input['password']);
  $sql = "INSERT INTO $warriors_table VALUES('$input[user_id]','$encrypted_pass',$input[cadre_flag],
  '$input[army_num]',$input[unit_id],'$input[email]','$input[phone]')";
  mysqli_query($dbconn,$sql);
  $res['success']=true;
}
catch(Exception $e){
  http_response_code(400); //bad request
  $res['message'] = $e->getMessage();
}

echo json_encode($res);
?>