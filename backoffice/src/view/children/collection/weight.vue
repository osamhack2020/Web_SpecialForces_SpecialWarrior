<template>
  <v-card v-if="isLoadedWeightData">
    <v-card-subtitle>
      <v-icon color="green">mdi-ruler</v-icon>
      병사 체중 상태
      <v-btn-toggle
        borderless
        v-model="weightArray.ascending"
        mandatory
        dense
        color="green"
        class="float-right"
        @change="sortWeightArray()"
      >
        <v-btn icon>
          <v-icon :color="weightArray.ascending?'':'green'">mdi-sort-numeric-descending</v-icon>
        </v-btn>
        <v-btn icon>
          <v-icon :color="weightArray.ascending?'green':''">mdi-sort-numeric-ascending</v-icon>
        </v-btn>
      </v-btn-toggle>
    </v-card-subtitle>
    <v-card-text>
      <barchart class="col-10 mx-auto" :chart-data="weightArray"></barchart>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../../store';
import barchart from './barchart.vue';
export default {
  name:'weight',
  components:{barchart},
  computed:{
    getSelectedUnit(){
      return this.$store.getters.getSelectedUnit;
    },
  },
  watch:{
    getSelectedUnit(){
      this.getWeightDataOfAll();
    },
  },
  created(){
    this.getWeightDataOfAll();
  },
  data:()=>({
    weightData:[],
    weightArray:{
      labels:[],
      datasets:[
        {
          label: '평균 체중',
          backgroundColor: '#ab47bc',
          data: [],
        },
        {
          label: '최소 체중',
          backgroundColor: '#f87979',
          data: [],
        },
        {
          label: '최대 체중',
          backgroundColor: '#4CAF50',
          data: [],
        },
      ],
      ascending:0,
      sorted:false,
      type:1,
    },
    isLoadedWeightData:false,
  }),
  methods:{
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
            this.setWeightArray();
            //Load Finished
            this.isLoadedWeightData = true;
          }
        });
    },
    initializeWeightArray(){
      this.weightArray = {
        labels:[],
        datasets:[
          {
            label: '평균 체중',
            backgroundColor: '#ab47bc',
            data: [],
          },
          {
            label: '최소 체중',
            backgroundColor: '#f87979',
            data: [],
          },
          {
            label: '최대 체중',
            backgroundColor: '#4CAF50',
            data: [],
          },
        ],
        ascending:0,
        sorted:false,
        type:1,
      };
    },
    setWeightArray(){
      this.initializeWeightArray();
      //이름
      this.weightData.forEach((item)=>{
        this.weightArray.labels.push(item.name);
      });
      //평균 수면시간
      this.weightData.forEach((item)=>{
        if(!item.min_max_avg.average) 
          this.weightArray.datasets[0].data.push(0);
        else
          this.weightArray.datasets[0].data.push(parseInt(item.min_max_avg.average));
      });
      //최소
      this.weightData.forEach((item)=>{
        if(!item.min_max_avg.min) 
          this.weightArray.datasets[1].data.push(0);
        else
          this.weightArray.datasets[1].data.push(parseInt(item.min_max_avg.min));
      });
      //최대
      this.weightData.forEach((item)=>{
        if(!item.min_max_avg.max) 
          this.weightArray.datasets[2].data.push(0);
        else
          this.weightArray.datasets[2].data.push(parseInt(item.min_max_avg.max));
      });
      
      this.sortWeightArray();
    },
    sortArraybySortOrder(array,order_array){
      return array.map((item,index)=>{return array[order_array[index]]});
    },
    sortWeightArray(){
        var sorted_order=[];
        //Get sort order with average
        if(this.weightArray.ascending)
        this.weightArray.datasets[0].data
        .map((item,index)=>{return {val:item,idx:index}})
        .sort((a,b)=>{return a.val - b.val})
        .map((item)=>{
          sorted_order.push(item.idx);
        });
        else
        this.weightArray.datasets[0].data
        .map((item,index)=>{return {val:item,idx:index}})
        .sort((a,b)=>{return b.val - a.val})
        .map((item)=>{
          sorted_order.push(item.idx);
        });
        //Sort Array
        this.weightArray.labels = this.sortArraybySortOrder(this.weightArray.labels,sorted_order);
        this.weightArray.datasets[0].data = this.sortArraybySortOrder(this.weightArray.datasets[0].data,sorted_order);
        this.weightArray.datasets[1].data = this.sortArraybySortOrder(this.weightArray.datasets[1].data,sorted_order);
        this.weightArray.datasets[2].data = this.sortArraybySortOrder(this.weightArray.datasets[2].data,sorted_order);
        this.weightArray.sorted=true;
        //change address of weightArray to fire redraw
        this.weightArray = {...this.weightArray};
    },
  },
}
</script>

<style>

</style>