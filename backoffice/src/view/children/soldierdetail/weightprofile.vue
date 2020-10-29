<template>
  <v-card>
    <v-card-subtitle>
      <v-icon color="green">mdi-ruler</v-icon>
      최근 30일간 체중
    </v-card-subtitle>
    <v-card-text>
      <v-sparkline
        fill
        smooth="15"
        :value="weightArray"
        auto-draw
        color="green"
        label-size="3"
      >
        <template v-slot:label="item" class="text-caption">
          {{ processEmpty(item.value,null,true) }}
        </template>
      </v-sparkline>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th>
                최저 체중
              </th>
              <th>
                최대 체중
              </th>
              <th>
                평균 체중
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ processEmpty(getArrayMin(weightArray),"kg") }}</td>
              <td>{{ processEmpty(getArrayMax(weightArray),"kg") }}</td>
              <td>{{ processEmpty(getArrayAverage(weightArray),"kg") }}</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name:'weightprofile',
  props:['weightArray'],
  data:()=>({
    
  }),
  methods:{
    processEmpty(str,unit='',dense=false){
      if(dense){
        if(str==0)
          return '-';
        return str;
      }
      else{
        if(!str)
          return this.stringEmpty;
        return str+' '+unit;
      }
    },
    getArrayMin(arr){
      var min = 987654321;
      arr.forEach((item)=>{
        if(item == 0) return;
        min = Math.min(min,item);
      });
      return min==987654321?0:min;
    },
    getArrayMax(arr){
      var max = 0;
      arr.forEach((item)=>{
        max = Math.max(max,item);
      });
      return max;
    },
    getArrayAverage(arr){
      var sum=0, cnt=0;
      arr.forEach((item)=>{
        if(item == 0) return;
        sum+=item;
        cnt++;
      });
      return cnt?(sum/cnt).toFixed(2):0;
    }
  }
}
</script>

<style>

</style>