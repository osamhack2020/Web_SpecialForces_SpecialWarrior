<template>
  <v-container>
    <v-card dark class="text-center mb-3 pa-3">
      <v-icon style="font-size:100px;">mdi-clipboard-list</v-icon>
      <v-divider class="ma-4"></v-divider>
      <span class="text-h2 font-weight-bold" style="">전사현황</span>
      <v-divider class="ma-4"></v-divider>
      <span class="text-h6 font-weight-medium mb-3">병사들의 체력검정 현황을 확인해보세요</span>
    </v-card>
    <grade></grade>
    <router-view></router-view>
  </v-container>
</template>

<script>
import grade from './warriorstatus/grade.vue';
export default {
  name:'warriorstatus',
  components:{grade},
  data:()=>({

  }),
  methods:{

  },
}
</script>

<style>

</style>