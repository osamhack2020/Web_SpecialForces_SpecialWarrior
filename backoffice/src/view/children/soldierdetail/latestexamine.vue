<template>
  <v-card>
    <v-card-subtitle>
      최근 체력검정
    </v-card-subtitle>
    <v-card-text>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th>
                팔굽혀펴기
              </th>
              <th>
                윗몸일으키기
              </th>
              <th>
                뜀걸음
              </th>
              <th>
                평가 현황
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ processEmptyExerciseCount(userInfo.latest_examine_data.latest_pushup,"회") }}</td>
              <td>{{ processEmptyExerciseCount(userInfo.latest_examine_data.latest_situp,"회") }} {{userInfo.latest_examine_data.latest_situp}}</td>
              <td>{{ processEmptyExerciseTime(userInfo.latest_examine_data.latest_run) }}</td>
              <td>{{ getExamineGradeToKorean(userInfo.latest_examine_data.grade) }}</td>
            </tr>
            <tr>
              <td>{{ processEmptyExerciseDateTime(userInfo.latest_examine_data.latest_pushup) }}</td>
              <td>{{ processEmptyExerciseDateTime(userInfo.latest_examine_data.latest_situp) }}</td>
              <td>{{ processEmptyExerciseDateTime(userInfo.latest_examine_data.latest_run) }}</td>
              <td></td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name:'latestexamine',
  props:{
    userInfo:Object,
  },
  data:()=>({
  }),
  methods:{
    getExamineGradeToKorean(grade){
      switch(parseInt(grade)){
          case 0:
              return "특급";
          case 1:
              return "1급";
          case 2:
              return "2급";
          case 3:
              return "3급";
          case 999:
              return "불합격";
      }
    },
    processEmptyExerciseCount(exercise){
      if(!exercise)
        return this.stringEmptyExercise;
      return exercise.exercise_count+' 회';
    },
    processEmptyExerciseTime(exercise){
      if(!exercise)
        return this.stringEmptyExercise;
      return this.getMinuteAndSecond(exercise.exercise_time);
    },
    processEmptyExerciseDateTime(exercise){
      if(!exercise)
        return this.stringEmptyExercise;
      return exercise.created_at;
    },
  }
}
</script>

<style>

</style>