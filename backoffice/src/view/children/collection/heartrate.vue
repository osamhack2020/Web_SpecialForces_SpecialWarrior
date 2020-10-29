<template>
  <v-card>
    <v-card-subtitle>
      <v-icon color="red darken-1">mdi-heart</v-icon>
      병사 심박수 상태
      <v-btn-toggle
        borderless
        v-model="heartrateArray.ascending"
        mandatory
        dense
        color="red darken-1"
        class="float-right"
        @change="sortHeartrateArray()"
      >
        <v-btn icon>
          <v-icon :color="heartrateArray.ascending?'':'red darken-1'">mdi-sort-numeric-descending</v-icon>
        </v-btn>
        <v-btn icon>
          <v-icon :color="heartrateArray.ascending?'red darken-1':''">mdi-sort-numeric-ascending</v-icon>
        </v-btn>
      </v-btn-toggle>
    </v-card-subtitle>
    <v-card-text>
      <v-skeleton-loader
        loading
        type="article, article, article"
        v-show="!isLoadedHeartrateData"
      ></v-skeleton-loader>
      <barchart v-if="isLoadedHeartrateData" class="col-10 mx-auto" :chart-data="heartrateArray"></barchart>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../../store';
import barchart from './barchart.vue';
export default {
  name:'heartrate',
  components:{barchart},
  props:['selectedDate'],
  computed:{
    getSelectedUnit(){
      return this.$store.getters.getSelectedUnit;
    },
  },
  watch:{
    getSelectedUnit(){
      this.getHeartrateDataOfAll();
    },
    selectedDate(){
      this.getHeartrateDataOfAll();
    }
  },
  created(){
    this.initializeHeartrateArray();
    this.getHeartrateDataOfAll();
  },
  data:()=>({
    heartrateData:[],
    heartrateArray:{},
    isLoadedHeartrateData:false,
  }),
  methods:{
    getHeartrateDataOfAll(){
        return axios(
          {
            method: 'post',
            url: `${resourceHost}/cadre/get_heartrate_data_of_all`,
            data:{
              unit_id:this.$store.getters.getSelectedUnit.unit_id,
              date:this.selectedDate,
            }
        })
        .then((response)=>{
          if(response.status==200){
            this.heartrateData = response.data;
            this.setHeartrateArray();
            //Load Finished
            
          }
        });
    },
    initializeHeartrateArray(){
      this.heartrateArray = {
        labels:[],
        datasets:[
          {
            label: '평균 심박수',
            backgroundColor: '#ab47bc',
            data: [],
          },
          {
            label: '최소 심박수',
            backgroundColor: '#f87979',
            data: [],
          },
          {
            label: '최대 심박수',
            backgroundColor: '#4CAF50',
            data: [],
          },
        ],
        ascending:0,
        sorted:false,
        type:2,
      };
    },
    setHeartrateArray(){
      this.initializeHeartrateArray();
      //이름
      this.heartrateData.forEach((item)=>{
        this.heartrateArray.labels.push(item.name);
      });
      //평균 수면시간
      this.heartrateData.forEach((item)=>{
        if(!item.min_max_avg.average) 
          this.heartrateArray.datasets[0].data.push(0);
        else
          this.heartrateArray.datasets[0].data.push(parseInt(item.min_max_avg.average));
      });
      //최소
      this.heartrateData.forEach((item)=>{
        if(!item.min_max_avg.min) 
          this.heartrateArray.datasets[1].data.push(0);
        else
          this.heartrateArray.datasets[1].data.push(parseInt(item.min_max_avg.min));
      });
      //최대
      this.heartrateData.forEach((item)=>{
        if(!item.min_max_avg.max) 
          this.heartrateArray.datasets[2].data.push(0);
        else
          this.heartrateArray.datasets[2].data.push(parseInt(item.min_max_avg.max));
      });
      
      this.sortHeartrateArray();
      this.isLoadedHeartrateData = true;
    },
    sortArraybySortOrder(array,order_array){
      return array.map((item,index)=>{return array[order_array[index]]});
    },
    sortHeartrateArray(){
        var sorted_order=[];
        //Get sort order with average
        if(this.heartrateArray.ascending)
        this.heartrateArray.datasets[0].data
        .map((item,index)=>{return {val:item,idx:index}})
        .sort((a,b)=>{return a.val - b.val})
        .map((item)=>{
          sorted_order.push(item.idx);
        });
        else
        this.heartrateArray.datasets[0].data
        .map((item,index)=>{return {val:item,idx:index}})
        .sort((a,b)=>{return b.val - a.val})
        .map((item)=>{
          sorted_order.push(item.idx);
        });
        //Sort Array
        this.heartrateArray.labels = this.sortArraybySortOrder(this.heartrateArray.labels,sorted_order);
        for(var i=0;i<this.heartrateArray.datasets.length;i++){
          this.heartrateArray.datasets[i].data = this.sortArraybySortOrder(this.heartrateArray.datasets[i].data,sorted_order);
        }
        this.heartrateArray.sorted=true;
        //change address of heartrateArray to fire redraw
        this.heartrateArray = {...this.heartrateArray};
    },
  },
}
</script>

<style>

</style>