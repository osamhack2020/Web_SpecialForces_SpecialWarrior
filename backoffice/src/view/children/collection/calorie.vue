<template>
  <v-card>
    <v-card-subtitle>
      <v-icon color="orange darken-1">mdi-fire</v-icon>
      병사 칼로리 섭취 상태
      <v-btn-toggle
        borderless
        v-model="calorieArray.ascending"
        mandatory
        dense
        color="orange darken-1"
        class="float-right"
        @change="sortCalorieArray()"
      >
        <v-btn icon>
          <v-icon :color="calorieArray.ascending?'':'orange darken-1'">mdi-sort-numeric-descending</v-icon>
        </v-btn>
        <v-btn icon>
          <v-icon :color="calorieArray.ascending?'orange darken-1':''">mdi-sort-numeric-ascending</v-icon>
        </v-btn>
      </v-btn-toggle>
    </v-card-subtitle>
    <v-card-text>
      <v-skeleton-loader
        loading
        type="article, article, article"
        v-show="!isLoadedCalorieData"
      ></v-skeleton-loader>
      <barchart v-if="isLoadedCalorieData" class="col-10 mx-auto" :chart-data="calorieArray"></barchart>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../../store';
import barchart from './barchart.vue';
export default {
  name:'calorie',
  components:{barchart},
  props:['selectedDate'],
  computed:{
    getSelectedUnit(){
      return this.$store.getters.getSelectedUnit;
    },
  },
  watch:{
    getSelectedUnit(){
      this.getCalorieDataOfAll();
    },
    selectedDate(){
      this.getCalorieDataOfAll();
    }
  },
  created(){
    this.initializeCalorieArray();
    this.getCalorieDataOfAll();
  },
  data:()=>({
    calorieData:[],
    calorieArray:{},
    isLoadedCalorieData:false,
  }),
  methods:{
    getCalorieDataOfAll(){
        return axios(
          {
            method: 'post',
            url: `${resourceHost}/cadre/get_calorie_data_of_all`,
            data:{
              unit_id:this.$store.getters.getSelectedUnit.unit_id,
              date:this.selectedDate,
            }
        })
        .then((response)=>{
          if(response.status==200){
            this.calorieData = response.data;
            this.setCalorieArray();
            //Load Finished
          }
        });
    },
    initializeCalorieArray(){
      if(this.selectedDate){
        this.calorieArray = {
          labels:[],
          datasets:[
            {
              label: '평균 칼로리 섭취',
              backgroundColor: '#4CAF50',
              data: [],
            },
          ],
          ascending:0,
          sorted:false,
          type:3,
        };
        return;
      }
      this.calorieArray = {
        labels:[],
        datasets:[
          {
            label: '평균 칼로리 섭취',
            backgroundColor: '#ab47bc',
            data: [],
          },
          {
            label: '최소 칼로리 섭취',
            backgroundColor: '#f87979',
            data: [],
          },
          {
            label: '최대 칼로리 섭취',
            backgroundColor: '#4CAF50',
            data: [],
          },
        ],
        ascending:0,
        sorted:false,
        type:3,
      };
    },
    setCalorieArray(){
      this.initializeCalorieArray();
      //이름
      this.calorieData.forEach((item)=>{
        this.calorieArray.labels.push(item.name);
      });
      if(!this.selectedDate){
        //평균
        this.calorieData.forEach((item)=>{
          if(!item.min_max_avg.average) 
            this.calorieArray.datasets[0].data.push(0);
          else
            this.calorieArray.datasets[0].data.push(parseInt(item.min_max_avg.average));
        });
        //최소
        this.calorieData.forEach((item)=>{
          if(!item.min_max_avg.min) 
            this.calorieArray.datasets[1].data.push(0);
          else
            this.calorieArray.datasets[1].data.push(parseInt(item.min_max_avg.min));
        });
        //최대
        this.calorieData.forEach((item)=>{
          if(!item.min_max_avg.max) 
            this.calorieArray.datasets[2].data.push(0);
          else
            this.calorieArray.datasets[2].data.push(parseInt(item.min_max_avg.max));
        });
      }
      else{
        //체중
        this.calorieData.forEach((item)=>{
          if(!item.result[0].calorie) 
            this.calorieArray.datasets[0].data.push(0);
          else
            this.calorieArray.datasets[0].data.push(parseInt(item.result[0].calorie));
        });
      }
      
      this.sortCalorieArray();
      this.isLoadedCalorieData = true;
    },
    sortArraybySortOrder(array,order_array){
      return array.map((item,index)=>{return array[order_array[index]]});
    },
    sortCalorieArray(){
        var sorted_order=[];
        //Get sort order with average
        if(this.calorieArray.ascending)
        this.calorieArray.datasets[0].data
        .map((item,index)=>{return {val:item,idx:index}})
        .sort((a,b)=>{return a.val - b.val})
        .map((item)=>{
          sorted_order.push(item.idx);
        });
        else
        this.calorieArray.datasets[0].data
        .map((item,index)=>{return {val:item,idx:index}})
        .sort((a,b)=>{return b.val - a.val})
        .map((item)=>{
          sorted_order.push(item.idx);
        });
        //Sort Array
        this.calorieArray.labels = this.sortArraybySortOrder(this.calorieArray.labels,sorted_order);
        for(var i=0;i<this.calorieArray.datasets.length;i++){
          this.calorieArray.datasets[i].data = this.sortArraybySortOrder(this.calorieArray.datasets[i].data,sorted_order);
        }
        this.calorieArray.sorted=true;
        //change address of calorieArray to fire redraw
        this.calorieArray = {...this.calorieArray};
    },
  },
}
</script>

<style>

</style>