<template>
  <v-container>
    <sleeptime></sleeptime>
    <weight class="mt-3"></weight>
    <heartrate class="mt-3"></heartrate>
    <calorie class="mt-3"></calorie>
  </v-container>
</template>

<script>
import sleeptime from './collection/sleeptime.vue';
import weight from './collection/weight.vue';
import heartrate from './collection/heartrate.vue';
import calorie from './collection/calorie.vue';

export default {
    name:'collection_month',
    components:{sleeptime,weight,heartrate,calorie},
    data:()=>({
    }),
    methods:{
    },

}
</script>

<style>
</style>