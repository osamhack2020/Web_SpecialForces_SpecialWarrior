<template>
  <v-container>
    <v-card dark class="text-center mb-3 pa-3">
			<v-icon style="font-size:100px;">mdi-frequently-asked-questions</v-icon>
			<v-divider class="ma-4"></v-divider>
			<span class="text-h2 font-weight-bold" style="">FAQ</span>
			<v-divider class="ma-4"></v-divider>
			<span class="text-h6 font-weight-medium mb-3">자주 묻는 사항들을 확인해보세요</span>
		</v-card>
    <v-container v-if="isLoading" class="text-center">
      <v-progress-circular
        indeterminate
        color="primary"
      ></v-progress-circular>
    </v-container>
    <v-container class="text-center" v-if="faq.length==0 && !isLoading">
      FAQ가 없습니다
    </v-container>
    <v-expansion-panels focusable popout>
      <v-expansion-panel
        v-for="(item,i) in faq"
        :key="i"
      >
        <v-expansion-panel-header>
          {{item.question}}
          <template v-slot:actions>
            <v-icon color="primary">
              $expand
            </v-icon>
          </template>
        </v-expansion-panel-header>
        <v-expansion-panel-content>
          <span class="text-body-1">{{item.answer}}</span>
          <div class="block text-right" v-if="isAdmin">
            <v-icon
              @click="deleteFaq(item.faq_id)"
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
      v-if="isAdmin"
      @click="$router.push('faq/write')"
    ><v-icon>mdi-pencil</v-icon></v-btn>
    <router-view></router-view>
  </v-container>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../store';

export default {
    name:'faq',
    data:()=>({
      faq:[],
      isLoading:false,
      isHovering:false,
    }),
    created:function(){
      this.getFaq();
    },
    computed:{
      isFaqNeedRefresh(){
        return this.$store.getters.getIsFaqNeedRefresh;
      },
      isAdmin(){
        return this.$store.getters.getUserData.admin_flag;
      }
    },
    watch:{
      isFaqNeedRefresh(){
        if(this.isFaqNeedRefresh) {
          this.getFaq();
          this.$store.commit('SetFaqRefresh',false);
        }
      }
    },
    methods:{
      getFaq(){
        this.isLoading = true;
        axios(
          {
          method: 'get',
          url: `${resourceHost}/faq/get_faq`,
        })
        .then((response)=>{
            if(response.status==200){
                this.faq = response.data.result;
                this.isLoading = false;
            }
        });
      },
      deleteFaq(faq_id){
          this.isLoading=true;
          axios(
            {
            method: 'post',
            url: `${resourceHost}/cadre/delete_faq`,
            data:{
              faq_id:faq_id,
            }
          })
          .then((response)=>{
              if(response.status==200){
                  this.isLoading=false;
                  this.getFaq();
                  this.$store.commit('pushAlert',{message:"FAQ를 삭제했습니다",type:"info"});
              }
          });
        },
    },
}
</script>

<style>

</style>