<template>
  <v-container>
    <v-expansion-panels focusable popout>
      <v-progress-circular
      v-if="notice.length==0"
      indeterminate
      color="primary"
      ></v-progress-circular>
      <v-expansion-panel
        v-for="(item,i) in notice"
        :key="i"
      >
        <v-expansion-panel-header>
          <v-row no-gutters>
            <v-col class="col-7 text-truncate">
              {{item.subject}}
            </v-col>
            <v-col class="col-5 float-right text-right text--secondary">
                    <div class="mr-1"><v-icon small>mdi-account</v-icon>{{item.name}}</div>
                    <div class="mr-1"><v-icon small>mdi-clock</v-icon>{{getDate(item.created_at)}}</div>
            </v-col>
          </v-row>
        </v-expansion-panel-header>
        <v-expansion-panel-content>
          <span class="text-body-2">{{item.content}}</span>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
    <v-btn
      elevation="2"
      fab
      dark
      bottom
      right
      fixed
    ><v-icon>mdi-pencil</v-icon></v-btn>
  </v-container>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../store';
export default {

    name:'notice',
    data:()=>({
      notice:[],
    }),
    created:function(){
      this.getNotice();
    },
    methods:{
        getNotice(){
          axios(
            {
            method: 'get',
            url: `${resourceHost}/notice/get_notice`,
          })
          .then((response)=>{
              if(response.status==200){
                  this.notice = response.data.result;
              }
          });
        },
        getDate(datetime) {
          let date = new Date(datetime);
          let dateString = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
          return dateString;
        }
    },
}
</script>

<style>

</style>