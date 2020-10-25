<template>
  <v-card>
    <v-card-subtitle>
      유저 정보
    </v-card-subtitle>
    <v-card-text>
      <v-list-item two-line>
        <v-list-item-content>
          <v-list-item-subtitle>{{header.user_id}}</v-list-item-subtitle>
          <v-list-item-title>{{userInfo.user_id}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item two-line>
        <v-list-item-content>
          <v-list-item-subtitle>{{header.class}}</v-list-item-subtitle>
          <v-list-item-title>{{getMilClass(userInfo.class)}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item two-line>
        <v-list-item-content>
          <v-list-item-subtitle>{{header.name}}</v-list-item-subtitle>
          <v-list-item-title>{{userInfo.name}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item two-line>
        <v-list-item-content>
          <v-list-item-subtitle>{{header.army_num}}</v-list-item-subtitle>
          <v-list-item-title>{{userInfo.army_num}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item two-line>
        <v-list-item-content>
          <v-list-item-subtitle>{{header.email}}</v-list-item-subtitle>
          <v-list-item-title>{{userInfo.email}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item two-line>
        <v-list-item-content>
          <v-list-item-subtitle>{{header.phone}}</v-list-item-subtitle>
          <v-list-item-title>{{userInfo.phone}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name:'userinfo',
  props:['userInfo'],
  data:()=>({
    header:{
      user_id:"아이디",
      class:"계급",
      name:"이름",
      army_num:"군번",
      email:"이메일",
      phone:"전화번호"
    },
  }),
  methods:{
    getMilClass(classnum){
      switch(parseInt(classnum)){
        case 0:
          return "이병";
        case 1:
          return "일병";
        case 2:
          return "상병";
        case 3:
          return "병장";
      }
    },
  }
}
</script>

<style>

</style>