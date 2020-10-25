<template>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="80vh"
    >
      <v-card>
        <v-toolbar dark>
          <v-btn
            icon
            @click="closeDialog()"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>FAQ 글쓰기</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              icon
              @click="writeFaq()"
            >
              <v-icon>mdi-content-save</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-container>
          <v-text-field
            clearable
            clear-icon="mdi-close-circle"
            label="질문"
            v-model="question"
          ></v-text-field>
          <v-textarea
            filled
            label="답변"
            auto-grow
            v-model="answer"
          ></v-textarea>
        </v-container>
      </v-card>
    </v-dialog>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../store';
export default {
    name:'faq_write',
    data:()=>({
        dialog:true,
        question:"",
        answer:"",
    }),
    methods:{
        closeDialog(){
            this.dialog=false;
            this.refreshFaq();
            this.$router.push('/faq');
        },
        writeFaq(){
            if(!this.question || !this.answer) {
              this.$store.commit('showSnackbar',{message:"질문, 응답을 작성해주세요"});
              return;
            }
            axios(
                {
                method: 'post',
                url: `${resourceHost}/cadre/write_faq`,
                data:{
                    question:this.question,
                    answer:this.answer,
                }
              })
              .then((response)=>{
                  if(response.status==200){
                    this.$store.commit('pushAlert',{message:"FAQ를 추가했습니다",type:"info"});
                    this.closeDialog();
                  }
              });
        },
        refreshFaq(){
            this.$store.commit('SetFaqRefresh',true);
        }
    }

}
</script>

<style>

</style>