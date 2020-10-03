<template>
  <v-container fill-height>
    <v-card
      class="mx-auto px-5 col-3"
      align="center"
      elevation="10"
    >
      <v-card-title>
        Login
      </v-card-title>
      <v-card-text>
        <v-text-field
        v-model="id"
        outlined dense
        label="ID"
      ></v-text-field>
      <v-text-field
        v-model="pw"
        clearable
        clear-icon="mdi-close-circle"
        outlined dense
        label="PASSWORD"
        type="password"
      ></v-text-field>
        <v-btn class="mb-3" dark block @click="login(id,pw)">
          Login
        </v-btn>
        계정이 없나요? 
        <v-text 
        class="text-decoration-underline blue--text"
        @click="showSignUpForm=true">
          가입하기
        </v-text>
      </v-card-text>
    </v-card>
    <v-dialog
      v-model="showSignUpForm"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">회원가입</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
              >
                <v-text-field
                  label="아이디*"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="비밀번호*"
                  type="password"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="비밀번호 확인*"
                  type="password"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="이메일*"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="전화번호*"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  label="군번*"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>*은 필수 작성입니다</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="showSignUpForm = false"
          >
            닫기
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="showSignUpForm = false"
          >
            회원가입
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>


export default {
    name:'loginpage',
    data: () => ({
      id:"",pw:"",
      showSignUpForm:true,
    }),
    methods:{
      login(id,pw){
        this.$store.dispatch('getUserCredentialWith', {id, pw});
      },
    }
}
</script>

<style>

</style>