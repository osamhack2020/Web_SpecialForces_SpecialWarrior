<template>
  <v-card class="mt-3 text-black">
    <v-card-subtitle>
      <v-icon color="purple lighten-1">mdi-power-sleep</v-icon>
      최근 30일간 수면시간
    </v-card-subtitle>
    <v-card-text>
      <v-sparkline
        fill
        smooth="15"
        :value="sleeptimeArray"
        auto-draw
        color="purple lighten-1"
        label-size="3"
      >
        <template v-slot:label="item" class="text-caption">
          {{ getHourAndMinute(item.value,true) }}
        </template>
      </v-sparkline>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th>
                최저 수면시간
              </th>
              <th>
                최대 수면시간
              </th>
              <th>
                평균 수면시간
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ getHourAndMinute(userSleeptimeData.min_max_avg,false,1) }}</td>
              <td>{{ getHourAndMinute(userSleeptimeData.min_max_avg,false,2) }}</td>
              <td>{{ getHourAndMinute(userSleeptimeData.min_max_avg,false,3) }}</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name:'sleeptime',
  props:['sleeptimeArray','userSleeptimeData'],
  data:()=>({
  }),
  methods:{
    getHourAndMinute(minute,dense=false,min_max_avg=0){
      if(min_max_avg){
        if(minute == null || typeof minute == 'undefined')
          return this.stringEmpty;
        else{
          if(min_max_avg==1)
            minute = minute.min;
          else if(min_max_avg==2)
            minute = minute.max;
          else if(min_max_avg==3)
            minute = minute.average;
        }
      }

      minute = parseInt(minute);
      if(dense){
        if(!minute) return '-';
        return `${this.fillzero(String(parseInt(minute/60)))}:${this.fillzero(String(parseInt(minute%60)))}`;
      }
      else{
        if(!minute) return this.stringEmpty;
        return `${parseInt(minute/60)}시간 ${parseInt(minute%60)}분`;
      }
    },
    fillzero(numString){
      while(numString.length < 2){
        numString = '0'+numString;
      }
      return numString;
    }
  }
}
</script>

<style>

</style>