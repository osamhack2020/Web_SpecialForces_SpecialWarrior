<template>
  <v-container>
    <v-container v-if="isLoading" class="text-center">
      <v-progress-circular
        indeterminate
        color="primary"
      ></v-progress-circular>
    </v-container>
    <v-container class="text-center" v-if="notice.length==0 && !isLoading">
      공지사항이 없습니다
    </v-container>
    <v-expansion-panels focusable popout>
      <v-card-title>
        <v-icon left>mdi-information</v-icon>
        공지사항
      </v-card-title>
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
          <template v-slot:actions>
            <v-icon color="primary">
              $expand
            </v-icon>
          </template>
        </v-expansion-panel-header>
        <v-expansion-panel-content>
          <span class="text-body-2">{{item.content}}</span>
          <div class="block text-right">
            <v-icon
              @click="deleteNotice(item.notice_id)"
              @mouseover="isHovering = true" 
              @mouseout="isHovering = false" 
              :color="isHovering?'red':''"
            >
              mdi-delete
            </v-icon>
          </div>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
    <v-btn
      class="mb-13"
      elevation="2"
      fab
      dark
      bottom
      right
      fixed
      @click="$router.push('notice/write')"
    ><v-icon>mdi-pencil</v-icon></v-btn>
    <router-view></router-view>
  </v-container>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../store';
export default {

    name:'notice',
    data:()=>({
      isLoading:false,
      isHovering:false,
      notice:[],
      show:false,
    }),
    created:function(){
      this.getNotice();
    },
    computed:{
      isNoticeNeedRefresh(){
        return this.$store.getters.getIsNoticeNeedRefresh;
      },
      getSelectedUnit(){
        return this.$store.getters.getSelectedUnit;
      }
    },
    watch:{
      isNoticeNeedRefresh(){
        if(this.isNoticeNeedRefresh) {
          this.getNotice();
          this.$store.commit('SetNoticeRefresh',false);
        }
      },
      getSelectedUnit(){
        this.getNotice();
      }
    },
    methods:{
        getNotice(){
          this.isLoading=true;
          axios(
            {
            method: 'post',
            url: `${resourceHost}/notice/get_notice`,
            data:{
              unit_id:this.$store.getters.getSelectedUnit.unit_id,
            }
          })
          .then((response)=>{
              if(response.status==200){
                  this.notice = response.data.result;
                  this.isLoading=false;
              }
          });
        },
        deleteNotice(notice_id){
          this.isLoading=true;
          axios(
            {
            method: 'post',
            url: `${resourceHost}/cadre/delete_notice`,
            data:{
              notice_id:notice_id,
            }
          })
          .then((response)=>{
              if(response.status==200){
                  this.isLoading=false;
                  this.getNotice();
                  this.$store.commit('pushAlert',{message:"공지를 삭제했습니다",type:"info"});
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