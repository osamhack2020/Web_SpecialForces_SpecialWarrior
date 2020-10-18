<?php



/*
  Get Latest Examine Data Function
  2020-10-17 goraegori
  Input : user_id
  Output : success,result( latest_pushup(exercise_count,created_at), latest_situp(exercise_count,created_at), latest_run(exercise_time,created_at) )
*/

function get_latest_examine_data($dbconn,$user_id){
  //$input = json_decode(file_get_contents('php://input'),true);
  $res=array("success"=>false,"result"=>array("latest_pushup"=>null,"latest_situp"=>null,"latest_run"=>null));
  try{
    //Get latest pushup and information
    $sql = "SELECT exercise_count,created_at FROM exercise_profile WHERE user_id='$user_id' AND exercise_id=0 ORDER BY exercise_count DESC LIMIT 1;";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    $res['result']['latest_pushup'] = $row;
    
    //Get latest situp and information
    $sql = "SELECT exercise_count,created_at FROM exercise_profile WHERE user_id='$user_id' AND exercise_id=1 ORDER BY exercise_count DESC LIMIT 1;";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    $res['result']['latest_situp'] = $row;
    
    //Get latest run and information
    $sql = "SELECT exercise_time,created_at FROM exercise_profile WHERE user_id='$user_id' AND exercise_id=2 ORDER BY exercise_time DESC LIMIT 1;";
    $result = mysqli_query($dbconn,$sql);
    $row = mysqli_fetch_assoc($result);
    $res['result']['latest_run'] = $row;
    
    //Get Examine Grade
    $res['result']['grade'] = get_examine_grade(
      get_pushup_grade($res['result']['latest_pushup']['exercise_count']),
      get_situp_grade($res['result']['latest_situp']['exercise_count']),
      get_run_grade($res['result']['latest_run']['exercise_time'])
    );
    
    //Get Latest Examine
    $res['result']['latest_examine'] = get_latest_examine_date(
      $res['result']['latest_pushup']['created_at'],
      $res['result']['latest_pushup']['created_at'],
      $res['result']['latest_pushup']['created_at']
    );
    $res['success']=true;
  }
  catch(Exception $e){
    http_response_code(400); //bad request
    $res['message'] = $e->getMessage();
  }
  
  return $res;
}

/*
  Get Latest Examine Date Function
  2020-10-17 goraegori
  Input : date,date,date
  Output : date
*/
function get_latest_examine_date($pushup_date,$situp_date,$run_date){
  return max($pushup_date,$situp_date,$run_date);
}
/*
  Get Examine Grade Function
  2020-10-17 goraegori
  Input : grade,grade,grade
  Output : grade
*/
function get_examine_grade($pushup_grade,$situp_grade,$run_grade){
  return min($pushup_grade,$situp_grade,$run_grade);
}

/*
  Get Pushups Grade Function
  2020-10-17 goraegori
  Input : count
  Output : grade
*/
function get_pushup_grade($count){
  if(empty($count)) return 999;
  if($count <= 47)
    return 999;
  else if(48<=$count && $count <= 55)
    return 3;
  else if(56<=$count && $count <= 63)
    return 2;
  else if(64<=$count && $count <= 71)
    return 1;
  else if(72<=$count)
    return 0;
}

/*
  Get Situps Grade Function
  2020-10-17 goraegori
  Input : count
  Output : grade
*/
function get_situp_grade($count){
  if(empty($count)) return 999;
  if($count <= 57)
    return 999;
  else if(58<=$count && $count <= 65)
    return 3;
  else if(66<=$count && $count <= 73)
    return 2;
  else if(74<=$count && $count <= 81)
    return 1;
  else if(82<=$count)
    return 0;
}

/*
  Get Running Grade Function
  2020-10-17 goraegori
  Input : second
  Output : grade
*/
function get_run_grade($second){
  if(empty($second)) return 999;
  if($second <= 750)
    return 0;
  else if(751<=$second && $second <= 812)
    return 1;
  else if(813<=$second && $second <= 874)
    return 2;
  else if(875<=$second && $second <= 936)
    return 3;
  else if(937<=$second)
    return 999;
}
?>