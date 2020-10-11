<template>
  <v-app>
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
          <div>
          계정이 없나요? 
          </div>
          <div
          class="text-decoration-underline blue--text"
          @click="showSignUpForm=true">
            가입하기
          </div>
        </v-card-text>
      </v-card>

      <v-dialog
        v-model="showSignUpForm"
        max-width="600px"
      >
        <v-card>
          <v-card-title>
            <span class="headline">회원가입</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    v-model="signUpData.user_id"
                    label="아이디*"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="6" class="py-0">
                  <v-text-field
                    v-model="signUpData.password"
                    label="비밀번호*"
                    type="password"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="6" class="py-0">
                  <v-text-field
                    v-model="signUpData.password_again"
                    label="비밀번호 확인*"
                    type="password"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" v-if="signUpData.password != signUpData.password_again">
                  <div class="red--text font-weight-medium">
                      비밀번호가 다릅니다
                  </div>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    v-model="signUpData.email"
                    label="이메일*"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    v-model="signUpData.phone"
                    label="전화번호*"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    v-model="signUpData.army_num"
                    label="군번*"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    v-model="signUpData.unit_id"
                    label="소속*"
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
              @click="showSignUpForm = false; signup(signUpData);"
            >
              회원가입
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </v-app>
</template>

<script>


export default {
    name:'loginpage',
    data: () => ({
      id:"",pw:"",
      showSignUpForm:false,
      signUpData:{
        user_id:"",
        password:"",
        password_again:"",
        army_num:"",
        unit_id:"",
        email:"",
        phone:"",
      },
    }),
    methods:{
      login(id,pw){
        this.$store.dispatch('login', {id, pw});
      },
      signup(data){
        if(data.password == data.password_again){
          this.$store.dispatch('signup', data);
        }
      }
    }
}
</script>

<style>

</style>