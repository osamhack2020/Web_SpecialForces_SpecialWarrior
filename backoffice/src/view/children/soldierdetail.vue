<template>
    <v-bottom-sheet
      v-model="dialog"
      inset
    >
      <v-card>
        <v-toolbar>
          <v-btn
            icon
            @click="closeDialog()"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>{{getMilClass(userInfo.class)}} {{userInfo.name}}</v-toolbar-title>
        </v-toolbar>
        <v-container>
          <v-card>
            <v-card-subtitle>
              유저 정보
            </v-card-subtitle>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.user_id}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.user_id}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.class}}</v-list-item-subtitle>
                  <v-list-item-title>{{getMilClass(userInfo.class)}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.name}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.name}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.army_num}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.army_num}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.email}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.email}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.phone}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.phone}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-card>

            <v-card>
              <v-card-subtitle>
                일일 프로필
              </v-card-subtitle>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.user_id}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.user_id}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.class}}</v-list-item-subtitle>
                  <v-list-item-title>{{getMilClass(userInfo.class)}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.name}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.name}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.army_num}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.army_num}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.email}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.email}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-subtitle>{{header.phone}}</v-list-item-subtitle>
                  <v-list-item-title>{{userInfo.phone}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-card>
            {{userInfo}}
            <!--
            <v-sheet
              class="pa-3"
              v-if="isLoading"
            >
              <v-skeleton-loader
                type="list-item-avatar-three-line,card, article, article"
              ></v-skeleton-loader>
            </v-sheet>-->
        </v-container>
      </v-card>
    </v-bottom-sheet>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../store';
export default {
    name:'soldierdetail',
    data:()=>({
      isLoading:false,
      dialog:true,
      userInfo:{},
      header:{
        user_id:"아이디",
        class:"계급",
        name:"이름",
        army_num:"군번",
        email:"이메일",
        phone:"전화번호"
      },
    }),
    computed:{
      user_id(){
        return this.$route.params.user_id;
      }
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
        this.$router.push('../');
      },
      getWarriorInfo(){
        this.isLoading = true;
        axios(
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
            
            //Load Finished
            // this.isLoading = false;
          }
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

</style>