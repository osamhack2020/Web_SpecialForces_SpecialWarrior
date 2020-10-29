<template>
  <v-card>
    <v-card-subtitle>
      <v-icon>mdi-timelapse</v-icon>
      일일 프로필
      <v-chip small>{{userInfo.today_profile.date}}</v-chip>
    </v-card-subtitle>
    <v-card-text>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th>
                체중
              </th>
              <th>
                신장
              </th>
              <th>
                칼로리 섭취
              </th>
              <th>
                수면시간
              </th>
              <th>
                평균 심박수
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ processEmpty(userInfo.today_profile.weight,"kg") }}</td>
              <td>{{ processEmpty(userInfo.today_profile.height,"cm") }}</td>
              <td>{{ processEmpty(userInfo.today_profile.calorie,"kcal") }}</td>
              <td>{{ getHourAndMinute(userInfo.today_profile.sleep_time) }}</td>
              <td>{{ processEmpty(userInfo.today_profile.heartrate_average,"bpm") }}</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-card-text>
    <v-card-subtitle>
      <v-icon>mdi-label-percent</v-icon>
      BMI
      <v-chip small :color="getBMIColor()">{{ getBMILabel() }}</v-chip>
    </v-card-subtitle>
    <v-card-text class="text-center">
      <v-progress-linear
        :value="getBMIPercent()"
        :color="getBMIColor()"
        height="22"
        rounded
      >
        <strong>{{ getBMIPercent() }}</strong>
      </v-progress-linear>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name:'dailyprofile',
  props:['userInfo'],
  data:()=>({
    stringEmpty:"미입력",
    profileBmi:0,
  }),
  created(){
    this.getBMI(this.userInfo.today_profile.weight,this.userInfo.today_profile.height);
  },
  methods:{
    getBMI(weight,height){
      if(!weight || !height) return this.stringEmpty;
      this.profileBmi=(weight/(height*height)*10000).toFixed(2);
      return this.profileBmi;
    },
    getBMIPercent(){
      if(!this.profileBmi) return this.stringEmpty;
      return (this.profileBmi*2.5).toFixed(2) + '%';
    },
    getBMIColor(){
      if(!this.profileBmi) return this.stringEmpty;
      if( this.profileBmi < 18.5)
        //저체중
        return 'pink';
      else if(18.5 <= this.profileBmi && this.profileBmi < 25.0)
        //정상
        return 'success';
      else if(25 <= this.profileBmi && this.profileBmi < 30)
        //과체중
        return 'yellow';
      else if(30 <= this.profileBmi && this.profileBmi < 35)
        //경도 비만
        return 'amber';
      else if(35 <= this.profileBmi && this.profileBmi < 40)
        //중등도 비만
        return 'orange darken-2';
      else
        //고도 비만
        return 'red';
    },
    getBMILabel(){
      if(!this.profileBmi) return this.stringEmpty;
      if( this.profileBmi < 18.5){
        return '저체중';
      }
      else if(18.5 <= this.profileBmi && this.profileBmi < 25.0){
        return '정상';
      }
      else if(25 <= this.profileBmi && this.profileBmi < 30){
        return '과체중';
      }
      else if(30 <= this.profileBmi && this.profileBmi < 35){
        return '경도 비만';
      }
      else if(35 <= this.profileBmi && this.profileBmi < 40){
        return '중등도 비만';
      }
      else{
        return '고도 비만';
      }
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
    processEmpty(str,unit='',dense=false){
      if(dense){
        if(str==0)
          return '-';
        return str;
      }
      else{
        if(!str)
          return this.stringEmpty;
        return str+' '+unit;
      }
    },
    fillzero(numString){
      while(numString.length < 2){
        numString = '0'+numString;
      }
      return numString;
    },
  }
}
</script>

<style>

</style>