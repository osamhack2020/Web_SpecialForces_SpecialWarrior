<template>
    <v-container>
        <v-card v-if="isLoadedSleeptimeData">
            <v-card-subtitle>
              <v-icon color="purple lighten-1">mdi-power-sleep</v-icon>
              병사 평균수면 상태
            </v-card-subtitle>
            <v-card-text>
              {{ sleeptimeArray}}

              <!-- <v-sparkline
                smooth="15"
                :value="sleeptimeArray.times"
                auto-draw
                :auto-draw-duration='500'
                color="purple lighten-1"
                label-size="5"
                type="bar"
              >
                <template v-slot:label="item" class="text-caption">
                  {{ sleeptimeArray.names[item.index] }}
                  {{ getHourAndMinute(sleeptimeArray.times[item.index]) }}
                </template>
              </v-sparkline> -->
            </v-card-text>
        </v-card>
        <v-card class="mt-2" v-if="isLoadedWeightData">
            <v-card-subtitle>
                병사 체중 상태
            </v-card-subtitle>
        </v-card>
        <v-card class="mt-2">
            <v-card-subtitle>
                병사 칼로리 상태
            </v-card-subtitle>
        </v-card>
        <v-card class="mt-2">
            <v-card-subtitle>
                병사 평균 심박수 상태
            </v-card-subtitle>
        </v-card>
    </v-container>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../store';
export default {
    name:'collection',
    data:()=>({
        sleeptimeData:[],sleeptimeArray:{times:[],names:[]},isLoadedSleeptimeData:false,
        weightData:[],weightArray:[],isLoadedWeightData:false,

    }),
    computed:{
        getSelectedUnit(){
            return this.$store.getters.getSelectedUnit;
        }
    },
    watch:{
        getSelectedUnit(){
            this.getSleeptimeDataOfAll();
            this.getWeightDataOfAll();
        }
    },
    created(){
        this.getSleeptimeDataOfAll();
        this.getWeightDataOfAll();
    },
    methods:{
        getSleeptimeDataOfAll(){
            return axios(
              {
                method: 'post',
                url: `${resourceHost}/cadre/get_sleeptime_data_of_all`,
                data:{
                  unit_id:this.$store.getters.getSelectedUnit.unit_id,
                }
            })
            .then((response)=>{
              if(response.status==200){
                this.sleeptimeData = response.data;
                this.setSleeptimeArray();
                //Load Finished
                this.isLoadedSleeptimeData = true;
              }
            });
        },
        getWeightDataOfAll(){
            return axios(
              {
                method: 'post',
                url: `${resourceHost}/cadre/get_weight_data_of_all`,
                data:{
                  unit_id:this.$store.getters.getSelectedUnit.unit_id,
                }
            })
            .then((response)=>{
              if(response.status==200){
                this.weightData = response.data;
                //Load Finished
                this.isLoadedWeightData = true;
              }
            });
        },
        setSleeptimeArray(){
          this.sleeptimeData.forEach((item)=>{
            if(!item.min_max_avg.average) 
              this.sleeptimeArray.times.push(0);
            else
              this.sleeptimeArray.times.push(parseInt(item.min_max_avg.average));
            this.sleeptimeArray.names.push(item.name);
          });
        },
        setWeightArray(){
          this.weightData.result.forEach((item)=>{
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
        getHourAndMinute(minute,dense=false){
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
        fillzero(numString){
          while(numString.length < 2){
            numString = '0'+numString;
          }
          return numString;
        },
    },

}
</script>

<style>

</style>