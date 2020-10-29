<template>
  <v-card>
    <v-card-subtitle>
      <v-icon color="blue darken-2">mdi-podium-gold</v-icon>
      병사 체력 등급 현황
    </v-card-subtitle>
    <v-card-text>
      <v-skeleton-loader
        loading
        type="article, article, article"
        v-show="!isLoadedGradeData"
      ></v-skeleton-loader>
      <piechart v-if="isLoadedGradeData" class="col-10 mx-auto" :chart-data="gradeArray"></piechart>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th>
                특급
              </th>
              <th>
                1급
              </th>
              <th>
                2급
              </th>
              <th>
                3급
              </th>
              <th>
                불합격
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td v-for="(item,i) in gradeArray.datasets[0].users" :key="i">
                <v-chip class="mr-1" color="primary" v-for="(item,j) in gradeArray.datasets[0].users[i]" 
                :key="j" @click="$router.push('/warriorstatus/'+item.user_id)">
                  {{item.name}}
                  <v-icon right>mdi-arrow-right-drop-circle-outline</v-icon>
                </v-chip>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../../store';
import piechart from './piechart.vue';
export default {
  name:'grade',
  components:{piechart},
  computed:{
    getSelectedUnit(){
      return this.$store.getters.getSelectedUnit;
    },
  },
  watch:{
    getSelectedUnit(){
      this.getGradeDataOfAll();
    },
  },
  created(){
    this.initializeGradeArray();
    this.getGradeDataOfAll();
  },
  data:()=>({
    gradeData:[],
    gradeArray:{},
    isLoadedGradeData:false,
  }),
  methods:{
    getGradeDataOfAll(){
        return axios(
          {
            method: 'post',
            url: `${resourceHost}/cadre/get_grade_data_of_all`,
            data:{
              unit_id:this.$store.getters.getSelectedUnit.unit_id,
            }
        })
        .then((response)=>{
          if(response.status==200){
            this.gradeData = response.data;
            this.setGradeArray();
            //Load Finished
          }
        });
    },
    initializeGradeArray(){
        this.gradeArray = {
          labels:['특급','1급','2급','3급','불합격'],
          datasets:[
            {
              label: '체력 데이터',
              backgroundColor: ['#FBC02D','#1E88E5','#41B883','#F06292','#1E1E1E'],
              data: [0,0,0,0,0],
              users:[[],[],[],[],[]],
            },
          ],
        };
    },
    setGradeArray(){
      this.initializeGradeArray();
      this.gradeData.forEach((item)=>{
        this.gradeArray.datasets[0].data[this.getDatasetIndexForGrade(item.grade)]++;
        this.gradeArray.datasets[0].users[this.getDatasetIndexForGrade(item.grade)].push({name:item.name,user_id:item.user_id});
      });
      this.isLoadedGradeData = true;
    },
    getDatasetIndexForGrade(grade){
      switch(parseInt(grade)){
          case 0:
              return 0;
          case 1:
              return 1;
          case 2:
              return 2;
          case 3:
              return 3;
          case 999:
              return 4;
      }
    },
  },
}
</script>

<style>

</style>