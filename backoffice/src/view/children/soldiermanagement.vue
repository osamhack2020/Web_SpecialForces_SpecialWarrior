<template>
    <v-container>
        <v-card dark class="text-center mb-3 pa-3">
          <v-icon style="font-size:100px;">mdi-clipboard-account</v-icon>
          <v-divider class="ma-4"></v-divider>
          <span class="text-h2 font-weight-bold" style="">병사관리</span>
          <v-divider class="ma-4"></v-divider>
          <span class="text-h6 font-weight-medium mb-3">내 병사들의 건강상태를 확인하고 조언해보세요</span>
        </v-card>
        <v-card class="mt-3 px-3 pt-3">
            <v-chip-group
              mandatory
              active-class="primary--text"
              v-model="warriorClassFilter"
              @change="filterWarrior()"
            >
                <v-chip>전체</v-chip>
                <v-chip>一</v-chip>
                <v-chip>二</v-chip>
                <v-chip>三</v-chip>
                <v-chip>王</v-chip>
            </v-chip-group>
            <v-text-field
              dense
              outlined
              clearable
              single-line
              label="이름으로 검색"
              type="text"
              prepend-inner-icon="mdi-magnify"
              v-model="warriorNameFilter"
              @input="filterWarrior()"
            >
            </v-text-field>
        </v-card>

        <v-card class="mt-2 pa-3 text-center">
            <v-data-table
                :headers="headers"
                :items="filteredWarriors"
                :items-per-page="10"
                class="elevation-1"
                :loading="isLoading"
                hide-default-footer
                @page-count="pageCount = $event"
                :page.sync="page"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn :to="`management/${item.user_id}`">
                        <v-icon
                          small
                          class="mr-2"
                        >
                          mdi-account-details
                        </v-icon>
                    </v-btn>
                </template>
                <template
                  v-slot:no-data
                >
                  결과가 없습니다
                </template>
            </v-data-table>
            <v-pagination
                class="mt-2"
                v-model="page"
                :length="pageCount"
            ></v-pagination>
        </v-card>

        <router-view></router-view>
    </v-container>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../store';

export default {
    name:'soldiermanagement',
    data:()=>(
      { 
        isLoading:false,
        headers: [
          { text: '군번', value: 'army_num' },
          { text: '이름',value: 'name'},
          { text: '계급',value: 'class_korean'},
          { text: '어제 수면시간',value: 'today_profile.sleep_time'},
          { text: '체력등급',value: 'latest_examine_data.grade'},
          { text: '마지막 체력 측정',value: 'latest_examine_data.latest_examine'},
          { text: '자세히 보기', value: 'actions', sortable: false },
        ],
        page:1,
        pageCount:0,
        warriors:[],
        filteredWarriors:[],
        warriorClassFilter:0,
        warriorNameFilter:"",
    }),
    created(){
        this.getWarriors();
    },
    computed:{
        getSelectedUnit(){
            return this.$store.getters.getSelectedUnit;
        }
    },
    watch:{
        getSelectedUnit(){
            this.getWarriors();
        }
    },
    methods:{
        getWarriors(){
            this.isLoading = true;
            axios(
                {
                method: 'post',
                url: `${resourceHost}/cadre/get_warriors`,
                data:{
                    unit_id:this.$store.getters.getSelectedUnit.unit_id,
                }
              })
              .then((response)=>{
                  if(response.status==200){
                    this.warriors = response.data.result;
                    this.filterWarrior();
                    // Post Process
                    for(var i=0;i<this.warriors.length;i++){
                        this.warriors[i].latest_examine_data.grade = this.getExamineGradeToKorean(this.warriors[i].latest_examine_data.grade);
                        this.warriors[i].class_korean = this.getMilClass(this.warriors[i].class);
                        this.warriors[i].today_profile.sleep_time = this.getHourAndMinute(this.warriors[i].today_profile.sleep_time);
                    }

                    //Load Finished
                    this.isLoading = false;
                  }
              });
        },
        filterWarrior(){
            switch(this.warriorClassFilter){
                case 0:
                    this.filteredWarriors = this.warriors;
                    break;
                case 1:
                    this.filteredWarriors = this.warriors.filter(item => parseInt(item.class) == 0);
                    break;
                case 2:
                    this.filteredWarriors = this.warriors.filter(item => parseInt(item.class) == 1);
                    break;
                case 3:
                    this.filteredWarriors = this.warriors.filter(item => parseInt(item.class) == 2);
                    break;
                case 4:
                    this.filteredWarriors = this.warriors.filter(item => parseInt(item.class) == 3);
                    break;
            }
            this.filteredWarriors = this.filteredWarriors.filter(item => item.name.includes(this.warriorNameFilter));
        },
        getHourAndMinute(minute){
            if(!minute)
                return "미입력";
            return `${parseInt(minute/60)}시간 ${parseInt(minute%60)}분`;
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
        }
    },
}
</script>

<style>

</style>