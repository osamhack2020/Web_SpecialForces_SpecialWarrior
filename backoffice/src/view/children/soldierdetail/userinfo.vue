<template>
  <v-card class="mt-3">
    <v-card-subtitle>
      최근 30일간 수면시간(분)
    </v-card-subtitle>
    <v-card-text>
      <v-sparkline
        fill
        smooth="10"
        :value="sleeptimeArray"
        auto-draw
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
  name:'',
  data:()=>({
  }),
  methods:{
      
  }
}
</script>

<style>

</style>