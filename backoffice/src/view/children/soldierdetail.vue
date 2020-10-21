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
          <v-toolbar-title>{{user_id}} 정보</v-toolbar-title>
        </v-toolbar>
        <v-container>
            {{user_id}} 상세정보<br>
            {{userInfo}}
            <v-sheet
              class="pa-3"
              v-if="isLoading"
            >
              <v-skeleton-loader
                type="list-item-avatar-three-line,card, article, article"
              ></v-skeleton-loader>
            </v-sheet>
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
            this.userInfo = response.data.result;
            
            //Load Finished
            // this.isLoading = false;
          }
        });
      },
    },
}
</script>

<style>

</style>