<template>
  <v-container>
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