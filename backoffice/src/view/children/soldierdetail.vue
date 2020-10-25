<template>
    <v-bottom-sheet
      v-model="dialog"
      inset
      scrollable
    >
      <v-card>
        <v-toolbar dark>
          <v-toolbar-title>{{getMilClass(userInfo.class)}} {{userInfo.name}} 정보</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn
            icon
            @click="closeDialog()"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-container class="scroll-y" v-if="isLoadedUserInfo && isLoadedHeartrate && isLoadedWeight && isLoadedSleeptime">
          <v-card v-if="isLoadedUserInfo">
            <v-card-subtitle>
              유저 정보
            </v-card-subtitle>
            <v-card-text>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.user_id}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.user_id}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.class}}</v-list-item-subtitle>
                  <v-list-item-title>{{getMilClass(userInfo.class)}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.name}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.name}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.army_num}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.army_num}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.email}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.email}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.phone}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.phone}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-card-text>
          </v-card>

          <v-card class="mt-3" v-if="isLoadedUserInfo">
            <v-card-subtitle>
              일일 프로필
              <span class="text-caption">{{userInfo.today_profile.date}}</span>
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
              BMI
              <span class="text-caption">{{ getBMILabel() }}</span>
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

          <v-card class="mt-3" v-if="isLoadedUserInfo">
            <v-card-subtitle>
              최근 체력검정
            </v-card-subtitle>
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th>
                        팔굽혀펴기
                      </th>
                      <th>
                        윗몸일으키기
                      </th>
                      <th>
                        뜀걸음
                      </th>
                      <th>
                        평가 현황
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ processEmptyExerciseCount(userInfo.latest_examine_data.latest_pushup,"회") }}</td>
                      <td>{{ processEmptyExerciseCount(userInfo.latest_examine_data.latest_situp,"회") }}</td>
                      <td>{{ processEmptyExerciseTime(userInfo.latest_examine_data.latest_run) }}</td>
                      <td>{{ getExamineGradeToKorean(userInfo.latest_examine_data.grade) }}</td>
                    </tr>
                    <tr>
                      <td>{{ processEmptyExerciseDateTime(userInfo.latest_examine_data.latest_pushup) }}</td>
                      <td>{{ processEmptyExerciseDateTime(userInfo.latest_examine_data.latest_situp) }}</td>
                      <td>{{ processEmptyExerciseDateTime(userInfo.latest_examine_data.latest_run) }}</td>
                      <td></td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card-text>
          </v-card>

          <v-card class="mt-3 text-black" v-if="isLoadedSleeptime">
            <v-card-subtitle>
              <v-icon color="purple lighten-1">mdi-power-sleep</v-icon>
              최근 30일간 수면시간
            </v-card-subtitle>
            <v-card-text>
              <v-sparkline
                fill
                smooth="15"
                :value="sleeptimeArray"
                auto-draw
                color="purple lighten-1"
                label-size="3"
              >
                <template v-slot:label="item" class="text-caption">
                  {{ getHourAndMinute(item.value,true) }}
                </template>
              </v-sparkline>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th>
                        최저 수면시간
                      </th>
                      <th>
                        최대 수면시간
                      </th>
                      <th>
                        평균 수면시간
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ getHourAndMinute(userSleeptimeData.min_max_avg,false,1) }}</td>
                      <td>{{ getHourAndMinute(userSleeptimeData.min_max_avg,false,2) }}</td>
                      <td>{{ getHourAndMinute(userSleeptimeData.min_max_avg,false,3) }}</td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card-text>
          </v-card>

          <v-card class="mt-3" v-if="isLoadedWeight">
            <v-card-subtitle>
              <v-icon color="green">mdi-ruler</v-icon>
              최근 30일간 체중
            </v-card-subtitle>
            <v-card-text>
              <v-sparkline
                fill
                smooth="15"
                :value="weightArray"
                auto-draw
                color="green"
                label-size="3"
              >
                <template v-slot:label="item" class="text-caption">
                  {{ processEmpty(item.value,null,true) }}
                </template>
              </v-sparkline>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th>
                        최저 체중
                      </th>
                      <th>
                        최대 체중
                      </th>
                      <th>
                        평균 체중
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ processEmpty(getArrayMin(weightArray),"kg") }}</td>
                      <td>{{ processEmpty(getArrayMax(weightArray),"kg") }}</td>
                      <td>{{ processEmpty(getArrayAverage(weightArray),"kg") }}</td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card-text>
          </v-card>

          <v-card class="mt-3" v-if="isLoadedHeartrate">
            <v-card-subtitle>
              <v-icon color="red darken-1">mdi-heart</v-icon>
              최근 30일간 심박수
            </v-card-subtitle>
            <v-card-text>
              <v-sparkline
                fill
                smooth="15"
                :value="heartrateArray"
                auto-draw
                color="red darken-1"
                label-size="3"
              >
                <template v-slot:label="item" class="text-caption">
                  {{ processEmpty(item.value,null,true) }}
                </template>
              </v-sparkline>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th>
                        최저 심박수
                      </th>
                      <th>
                        최대 심박수
                      </th>
                      <th>
                        평균 심박수
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ processEmpty(getArrayMin(heartrateArray),"bpm") }}</td>
                      <td>{{ processEmpty(getArrayMax(heartrateArray),"bpm") }}</td>
                      <td>{{ processEmpty(getArrayAverage(heartrateArray),"bpm") }}</td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card-text>
          </v-card>
        </v-container>

        <v-sheet
          class="pa-3"
          v-if="!(isLoadedUserInfo && isLoadedHeartrate && isLoadedWeight && isLoadedSleeptime)"
        >
          <v-skeleton-loader
            type="list-item-avatar-three-line,card, article, article"
          ></v-skeleton-loader>
        </v-sheet>
      </v-card>
    </v-bottom-sheet>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../store';
export default {
    name:'soldierdetail',
    data:()=>({
      isLoadedUserInfo:false,
      isLoadedSleeptime:false,
      isLoadedHeartrate:false,
      isLoadedWeight:false,
      dialog:true,
      userInfo:[],
      userSleeptimeData:[],
      userHeartrateData:[],
      userWeightData:[],

      sleeptimeArray:[],
      heartrateArray:[],
      weightArray:[],

      header:{
        user_id:"아이디",
        class:"계급",
        name:"이름",
        army_num:"군번",
        email:"이메일",
        phone:"전화번호"
      },
      stringEmpty:"미입력",
      stringEmptyExercise:"미측정",
      profileBmi:0,
    }),
    computed:{
      user_id(){
        return this.$route.params.user_id;
      },
    },
    watch:{
      dialog(){
        if(!this.dialog){
          this.closeDialog();
        }
      }
    },
    created(){
      this.getWarriorInfo();
    },
    methods:{
      closeDialog(){
        this.dialog=false;
        this.$router.push('../');
      },
      getWarriorInfo(){
        return axios(
          {
            method: 'post',
            url: `${resourceHost}/cadre/get_warrior_info`,
            data:{
              user_id:this.user_id,
            }
        })
        .then((response)=>{
          if(response.status==200){
            this.userInfo = response.data.result[0];
            this.getBMI(this.userInfo.today_profile.weight,this.userInfo.today_profile.height);
            
            this.getSleeptimeData();
            this.getHeartrateData();
            this.getWeightData();
            //Load Finished
            this.isLoadedUserInfo = true;
          }
        });
      },
      getSleeptimeData(){
        return axios(
          {
            method: 'post',
            url: `${resourceHost}/cadre/get_sleeptime_data`,
            data:{
              user_id:this.user_id,
            }
        })
        .then((response)=>{
          if(response.status==200){
            this.userSleeptimeData = response.data;
            this.setSleeptimeArray();
            //Load Finished
            this.isLoadedSleeptime = true;
          }
        });
      },
      getWeightData(){
        return axios(
          {
            method: 'post',
            url: `${resourceHost}/cadre/get_weight_data`,
            data:{
              user_id:this.user_id,
            }
        })
        .then((response)=>{
          if(response.status==200){
            this.userWeightData = response.data;
            this.setWeightArray();
            //Load Finished
            this.isLoadedWeight = true;
          }
        });
      },
      getHeartrateData(){
        return axios(
          {
            method: 'post',
            url: `${resourceHost}/cadre/get_heartrate_data`,
            data:{
              user_id:this.user_id,
            }
        })
        .then((response)=>{
          if(response.status==200){
            this.userHeartrateData = response.data;
            this.setHeartrateArray();
            //Load Finished
            this.isLoadedHeartrate = true;
          }
        });
      },
      setSleeptimeArray(){
        this.userSleeptimeData.result.forEach((item)=>{
          if(!item.sleep_time) 
            this.sleeptimeArray.push(0);
          else
            this.sleeptimeArray.push(parseInt(item.sleep_time));
        });
      },
      setWeightArray(){
        this.userWeightData.result.forEach((item)=>{
          if(!item.weight) 
            this.weightArray.push(0);
          else
            this.weightArray.push(parseInt(item.weight));
        });
      },
      setHeartrateArray(){
        this.userHeartrateData.result.forEach((item)=>{
          if(!item.min_max_avg.average) 
            this.heartrateArray.push(0);
          else
            this.heartrateArray.push(parseInt(item.min_max_avg.average));
        });
      },
      getMilClass(classnum){
        switch(parseInt(classnum)){
          case 0:
            return "이병";
          case 1:
            return "일병";
          case 2:
            return "상병";
          case 3:
            return "병장";
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
      processEmptyExerciseCount(exercise){
        if(!exercise)
          return this.stringEmptyExercise;
        return exercise.exercise_count+' 회';
      },
      processEmptyExerciseTime(exercise){
        if(!exercise)
          return this.stringEmptyExercise;
        return this.getMinuteAndSecond(exercise.exercise_time);
      },
      processEmptyExerciseDateTime(exercise){
        if(!exercise)
          return this.stringEmptyExercise;
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
        if(!this.profileBmi) return;
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
      getExamineGradeToKorean(grade){
        switch(parseInt(grade)){
            case 0:
                return "특급";
            case 1:
                return "1급";
            case 2:
                return "2급";
            case 3:
                return "3급";
            case 999:
                return "불합격";
        }
      },
      fillzero(numString){
        while(numString.length < 2){
          numString = '0'+numString;
        }
        return numString;
      },
      getArrayMin(arr){
        var min = 987654321;
        arr.forEach((item)=>{
          if(item == 0) return;
          min = Math.min(min,item);
        });
        return min==987654321?0:min;
      },
      getArrayMax(arr){
        var max = 0;
        arr.forEach((item)=>{
          max = Math.max(max,item);
        });
        return max;
      },
      getArrayAverage(arr){
        var sum=0, cnt=0;
        arr.forEach((item)=>{
          if(item == 0) return;
          sum+=item;
          cnt++;
        });
        return cnt?(sum/cnt).toFixed(2):0;
      }
    },
}
</script>

<style>
  .scroll-y{
    overflow-y:scroll;
  }
  .v-card__subtitle{
    color:#000000DE !important;
  }
</style>