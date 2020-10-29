<template>
  <v-container>
    <sleeptime></sleeptime>
    <weight class="mt-3"></weight>
    <heartrate class="mt-3"></heartrate>
  </v-container>
</template>

<script>
import sleeptime from './collection/sleeptime.vue';
import weight from './collection/weight.vue';
import heartrate from './collection/heartrate.vue';

export default {
    name:'collection_month',
    components:{sleeptime,weight,heartrate},
    data:()=>({
    }),
    methods:{
    },

}
</script>

<style>
</style>