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
          <v-toolbar-title>공지 글쓰기</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              icon
              @click="writeNotice()"
            >
              <v-icon>mdi-content-save</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-container>
          <v-text-field
            clearable
            clear-icon="mdi-close-circle"
            label="제목"
            v-model="subject"
          ></v-text-field>
          <v-textarea
            filled
            label="내용"
            auto-grow
            v-model="content"
          ></v-textarea>
        </v-container>
      </v-card>
    </v-dialog>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../store';
export default {
    name:'notice_write',
    data:()=>({
        dialog:true,
        subject:"",
        content:"",
    }),
    methods:{
        closeDialog(){
            this.dialog=false;
            this.refreshNotice();
            this.$router.push('/notice');
        },
        writeNotice(){
            if(!this.subject || !this.content) {
              this.$store.commit('showSnackbar',{message:"제목, 내용을 작성해주세요"});
              return;
            }
            axios(
                {
                method: 'post',
                url: `${resourceHost}/cadre/write_notice`,
                data:{
                    unit_id:this.$store.getters.getSelectedUnit.unit_id,
                    subject:this.subject,
                    content:this.content,
                }
              })
              .then((response)=>{
                  if(response.status==200){
                    this.$store.commit('pushAlert',{message:"공지를 추가했습니다",type:"info"});
                    this.closeDialog();
                  }
              });
        },
        refreshNotice(){
            this.$store.commit('SetNoticeRefresh',true);
        }
    }

}
</script>

<style>

</style>