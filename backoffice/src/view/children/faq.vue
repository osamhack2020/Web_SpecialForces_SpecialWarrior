<template>
<v-container>
  <v-expansion-panels focusable popout>
    <v-progress-circular
      v-if="faq.length==0"
      indeterminate
      color="primary"
    ></v-progress-circular>
    <v-expansion-panel
      v-for="(item,i) in faq"
      :key="i"
    >
      <v-expansion-panel-header>
        {{item.question}}
      </v-expansion-panel-header>
      <v-expansion-panel-content>
        <span class="text-body-1">{{item.answer}}</span>
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</v-container>
</template>

<script>
import axios from 'axios';
import {resourceHost} from '../../store';

export default {
    name:'notice',
    data:()=>({
      faq:[],
    }),
    created:function(){
      this.getFaq();
    },
    methods:{
      getFaq(){
        axios(
          {
          method: 'get',
          url: `${resourceHost}/faq/get_faq`,
        })
        .then((response)=>{
            if(response.status==200){
                this.faq = response.data.result;
            }
        });
      }
    },
}
</script>

<style>

</style>