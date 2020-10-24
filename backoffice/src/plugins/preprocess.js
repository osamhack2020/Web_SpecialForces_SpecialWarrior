const stringEmpty = "미입력";
const stringEmptyExercise = "미측정";
export default{
  processEmpty(str,unit=''){
    if(!str)
      return stringEmpty;
    return str+' '+unit;
  },
  processEmptyExerciseCount(exercise){
    if(!exercise)
      return stringEmptyExercise;
    return exercise.exercise_count+' 회';
  },
  processEmptyExerciseTime(exercise){
    if(!exercise)
      return stringEmptyExercise;
    return this.getMinuteAndSecond(exercise.exercise_time);
  },
  processEmptyExerciseDateTime(exercise){
    if(!exercise)
      return stringEmptyExercise;
    return exercise.created_at;
  },
  getHourAndMinute(minute,dense=false,min_max_avg=0){
    if(min_max_avg){
      if(minute == null || typeof minute == 'undefined')
        return this.stringEmpty;
      else{
        if(min_max_avg==1)
          minute = minute.min;
        else if(min_max_avg==2)
          minute = minute.max;
        else if(min_max_avg==3)
          minute = minute.average;
      }
    }
    
    minute = parseInt(minute);
    if(dense){
      if(!minute) return '-';
      return `${this.fillzero(String(parseInt(minute/60)))}:${this.fillzero(String(parseInt(minute%60)))}`;
    }
    else{
      if(!minute) return this.stringEmpty;
      return `${parseInt(minute/60)}시간 ${parseInt(minute%60)}분`;
    }
  },
  getMinuteAndSecond(second){
    if(!second)
      return this.stringEmpty;
    return `${parseInt(second/60)}분 ${parseInt(second%60)}초`;
  },
  fillzero(numString){
    while(numString.length < 2){
      numString = '0'+numString;
    }
    return numString;
  }
};
