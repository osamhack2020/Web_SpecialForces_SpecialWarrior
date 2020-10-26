<template>
  <v-card>
    <v-card-subtitle>
      <v-icon color="purple lighten-1">mdi-power-sleep</v-icon>
      병사 수면 상태
      <v-btn-toggle
        borderless
        v-model="sleeptimeArray.ascending"
        mandatory
        dense
        color="purple"
        class="float-right"
        @change="sortSleeptimeArray()"
      >
        <v-btn icon>
          <v-icon :color="sleeptimeArray.ascending?'':'purple lighten-1'">mdi-sort-clock-descending-outline</v-icon>
        </v-btn>
        <v-btn icon>
          <v-icon :color="sleeptimeArray.ascending?'purple lighten-1':''">mdi-sort-clock-ascending-outline</v-icon>
        </v-btn>
      </v-btn-toggle>
    </v-card-subtitle>
    <v-card-text>
      <v-skeleton-loader
        loading
        type="article, article, article"
        v-show="!isLoadedSleeptimeData"
      ></v-skeleton-loader>
      <barchart v-if="isLoadedSleeptimeData" class="col-10 mx-auto" :chart-data="sleeptimeArray"></barchart>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../../store';
import barchart from './barchart.vue';
export default {
  name:'sleeptime',
  components:{barchart},
  props:['selectedDate'],
  computed:{
    getSelectedUnit(){
      return this.$store.getters.getSelectedUnit;
    },
  },
  watch:{
    getSelectedUnit(){
      this.getSleeptimeDataOfAll();
    },
    selectedDate(){
      this.getSleeptimeDataOfAll();
    }
  },
  created(){
    this.initailizeSleeptimeArray();
    this.getSleeptimeDataOfAll();
  },
  data:()=>({
    sleeptimeData:[],
    sleeptimeArray:{},
    isLoadedSleeptimeData:false,
  }),
  methods:{
    getSleeptimeDataOfAll(){
        return axios(
          {
            method: 'post',
            url: `${resourceHost}/cadre/get_sleeptime_data_of_all`,
            data:{
              unit_id:this.$store.getters.getSelectedUnit.unit_id,
              date:this.selectedDate,
            }
        })
        .then((response)=>{
          if(response.status==200){
            this.sleeptimeData = response.data;
            this.setSleeptimeArray();
            //Load Finished
            
          }
        });
    },
    initailizeSleeptimeArray(){
      if(this.selectedDate){
        this.sleeptimeArray = {
          labels:[],
          datasets:[
            {
              label: '수면시간',
              backgroundColor: '#ab47bc',
              data: [],
              hourAndMinute: [],
            },
          ],
          ascending:0,
          sorted:false,
          type:0,
        };
        return;
      }
      this.sleeptimeArray = {
        labels:[],
        datasets:[
          {
            label: '평균 수면시간',
            backgroundColor: '#ab47bc',
            data: [],
            hourAndMinute: [],
          },
          {
            label: '최소 수면시간',
            backgroundColor: '#f87979',
            data: [],
            hourAndMinute: [],
          },
          {
            label: '최대 수면시간',
            backgroundColor: '#4CAF50',
            data: [],
            hourAndMinute: [],
          },
        ],
        ascending:0,
        sorted:false,
        type:0,
      };
    },
    setSleeptimeArray(){
      this.initailizeSleeptimeArray();
      //이름
      this.sleeptimeData.forEach((item)=>{
        this.sleeptimeArray.labels.push(item.name);
      });
      if(!this.selectedDate){
        //평균 수면시간
        this.sleeptimeData.forEach((item)=>{
          if(!item.min_max_avg.average) 
            this.sleeptimeArray.datasets[0].data.push(0);
          else
            this.sleeptimeArray.datasets[0].data.push(parseInt(item.min_max_avg.average));
        });
        this.sleeptimeArray.datasets[0].data.forEach((item)=>{
          this.sleeptimeArray.datasets[0].hourAndMinute.push(this.getHourAndMinute(item));
        });
        //최소
        this.sleeptimeData.forEach((item)=>{
          if(!item.min_max_avg.min) 
            this.sleeptimeArray.datasets[1].data.push(0);
          else
            this.sleeptimeArray.datasets[1].data.push(parseInt(item.min_max_avg.min));
        });
        this.sleeptimeArray.datasets[1].data.forEach((item)=>{
          this.sleeptimeArray.datasets[1].hourAndMinute.push(this.getHourAndMinute(item));
        });
        //최대
        this.sleeptimeData.forEach((item)=>{
          if(!item.min_max_avg.max) 
            this.sleeptimeArray.datasets[2].data.push(0);
          else
            this.sleeptimeArray.datasets[2].data.push(parseInt(item.min_max_avg.max));
        });
        this.sleeptimeArray.datasets[2].data.forEach((item)=>{
          this.sleeptimeArray.datasets[2].hourAndMinute.push(this.getHourAndMinute(item));
        });
      }
      else{
        // 수면시간
        this.sleeptimeData.forEach((item)=>{
          if(!item.result[0].sleep_time) 
            this.sleeptimeArray.datasets[0].data.push(0);
          else
            this.sleeptimeArray.datasets[0].data.push(parseInt(item.result[0].sleep_time));
        });
        this.sleeptimeArray.datasets[0].data.forEach((item)=>{
          this.sleeptimeArray.datasets[0].hourAndMinute.push(this.getHourAndMinute(item));
        });
      }
      
      this.sortSleeptimeArray();
      this.isLoadedSleeptimeData = true;
    },
    sortArraybySortOrder(array,order_array){
      return array.map((item,index)=>{return array[order_array[index]]});
    },
    sortSleeptimeArray(){
        var sorted_order=[];
        //Get sort order with average
        if(this.sleeptimeArray.ascending)
        this.sleeptimeArray.datasets[0].data
        .map((item,index)=>{return {val:item,idx:index}})
        .sort((a,b)=>{return a.val - b.val})
        .map((item)=>{
          sorted_order.push(item.idx);
        });
        else
        this.sleeptimeArray.datasets[0].data
        .map((item,index)=>{return {val:item,idx:index}})
        .sort((a,b)=>{return b.val - a.val})
        .map((item)=>{
          sorted_order.push(item.idx);
        });
        //Sort Array
        this.sleeptimeArray.labels = this.sortArraybySortOrder(this.sleeptimeArray.labels,sorted_order);
        for(var i=0;i<this.sleeptimeArray.datasets.length;i++){
          this.sleeptimeArray.datasets[i].data = this.sortArraybySortOrder(this.sleeptimeArray.datasets[i].data,sorted_order);
          this.sleeptimeArray.datasets[i].hourAndMinute = this.sortArraybySortOrder(this.sleeptimeArray.datasets[i].hourAndMinute,sorted_order);
        }
        this.sleeptimeArray.sorted=true;
        //change address of sleeptimeArray to fire redraw
        this.sleeptimeArray = {...this.sleeptimeArray};
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