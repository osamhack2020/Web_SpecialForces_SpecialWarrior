<template>
  <v-container>
    <sleeptime :selectedDate="selectedDate"></sleeptime>
    <weight class="mt-3" :selectedDate="selectedDate"></weight>
    <heartrate class="mt-3" :selectedDate="selectedDate"></heartrate>
    <calorie class="mt-3" :selectedDate="selectedDate"></calorie>
  </v-container>
</template>

<script>
import sleeptime from './collection/sleeptime.vue';
import weight from './collection/weight.vue';
import heartrate from './collection/heartrate.vue';
import calorie from './collection/calorie.vue';

export default {
    name:'collection_day',
    components:{sleeptime,weight,heartrate,calorie},
    props:['selectedDate'],
    data:()=>({
      
    }),
    methods:{

    },

}
</script>

<style>
  .v-date-picker-title__date{
    font-size:32px;
  }
</style>