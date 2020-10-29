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
        <v-container class="scroll-y">
          <userinfo class="mt-3" v-if="isLoadedUserInfo" :userInfo="userInfo"></userinfo>

          <dailyprofile class="mt-3" v-if="isLoadedUserInfo" :userInfo="userInfo" ></dailyprofile>

          <latestexamine class="mt-3" v-if="isLoadedUserInfo" :userInfo="userInfo"></latestexamine>
          
          <sleeptime class="mt-3" v-if="isLoadedSleeptime" :sleeptimeArray="sleeptimeArray" :userSleeptimeData="userSleeptimeData"></sleeptime>

          <weightprofile class="mt-3" v-if="isLoadedWeight" :weightArray="weightArray" ></weightprofile>

          <heartrateprofile class="mt-3" v-if="isLoadedHeartrate" :heartrateArray="heartrateArray"></heartrateprofile>

          <calorieprofile class="mt-3" v-if="isLoadedCalorie" :calorieArray="calorieArray"></calorieprofile>
        </v-container>

        <v-sheet
          class="pa-3"
          v-if="!(isLoadedUserInfo && isLoadedHeartrate && isLoadedWeight && isLoadedSleeptime)"
        >
          <v-skeleton-loader
            loading
            type="list-item-avatar-three-line,card, article, article"
          ></v-skeleton-loader>
        </v-sheet>
      </v-card>
    </v-bottom-sheet>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../store';
import userinfo from './soldierdetail/userinfo.vue';
import dailyprofile from './soldierdetail/dailyprofile.vue';
import latestexamine from './soldierdetail/latestexamine.vue';
import sleeptime from './soldierdetail/sleeptime.vue';
import weightprofile from './soldierdetail/weightprofile.vue';
import heartrateprofile from './soldierdetail/heartrateprofile.vue';
import calorieprofile from './soldierdetail/calorieprofile.vue';

export default {
    name:'soldierdetail',
    props:['from'],
    components:{userinfo,sleeptime,dailyprofile,latestexamine,weightprofile,heartrateprofile,calorieprofile},
    data:()=>({
      isLoadedUserInfo:false,
      isLoadedSleeptime:false,
      isLoadedHeartrate:false,
      isLoadedWeight:false,
      isLoadedCalorie:false,
      dialog:true,
      userInfo:[],
      userSleeptimeData:[],
      userHeartrateData:[],
      userWeightData:[],
      userCalorieData:[],

      sleeptimeArray:[],
      heartrateArray:[],
      weightArray:[],
      calorieArray:[],

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
        this.$router.push('/'+this.from);
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
            
            this.getSleeptimeData();
            this.getHeartrateData();
            this.getWeightData();
            this.getCalorieData();
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
      getCalorieData(){
        return axios(
          {
            method: 'post',
            url: `${resourceHost}/cadre/get_calorie_data`,
            data:{
              user_id:this.user_id,
            }
        })
        .then((response)=>{
          if(response.status==200){
            this.userCalorieData = response.data;
            this.setCalorieArray();
            //Load Finished
            this.isLoadedCalorie = true;
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
      setCalorieArray(){
        this.userCalorieData.result.forEach((item)=>{
          if(!item.calorie) 
            this.calorieArray.push(0);
          else
            this.calorieArray.push(parseInt(item.calorie));
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