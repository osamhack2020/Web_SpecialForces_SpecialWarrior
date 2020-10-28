<template>
  <v-card>
    <v-card-subtitle>
      <v-icon>mdi-table-clock</v-icon>
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
              <td>{{ processEmptyExerciseCount(userInfo.latest_examine_data.latest_situp,"회") }}</td>
              <td>{{ processEmptyExerciseTime(userInfo.latest_examine_data.latest_run) }}</td>
              <td>{{ getExamineGradeToKorean(userInfo.latest_examine_data.grade) }}</td>
            </tr>
            <tr>
              <td>{{ getExamineGradeToKorean(userInfo.latest_examine_data.grades[0]) }}</td>
              <td>{{ getExamineGradeToKorean(userInfo.latest_examine_data.grades[1]) }}</td>
              <td>{{ getExamineGradeToKorean(userInfo.latest_examine_data.grades[2]) }}</td>
              <td></td>
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
  props:['userInfo'],
  data:()=>({
    stringEmptyExercise:"미측정",
    stringEmpty:"미입력"
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
    getMinuteAndSecond(second){
      if(!second)
        return this.stringEmpty;
      return `${parseInt(second/60)}분 ${parseInt(second%60)}초`;
    },
  }
}
</script>

<style>

</style>