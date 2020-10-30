<template>
  <v-app>
    <v-container fill-height>
      <v-card
        min-width="400"
        class="mx-auto px-5"
        align="center"
        elevation="10"
      >
        <v-card-title>
        <v-btn dark block large class="mb-4" @click="$router.push('/')">
          <v-icon>
            mdi-arm-flex
          </v-icon>
          SpecialForces
        </v-btn>
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
          @keyup.enter="login(id,pw)"
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
        <div class="mx-auto"
        align="center"
        elevation="10">
          <v-alert max-width="330" dense v-if="this.$store.state.alerts.length" :type="this.$store.state.alerts[this.$store.state.alerts.length-1].type">
            {{ this.$store.state.alerts[this.$store.state.alerts.length-1].message }}
          </v-alert>
        </div>
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
                    v-model="signUpData.name"
                    label="이름*"
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
                
                <v-col cols="12">
                  <v-menu offset-y>
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="signUpData.unit_full_name"
                        @input="findAfflication();"
                        v-bind="attrs"
                        v-on="on"
                        label="소속*"
                        required
                      ></v-text-field>
                    </template>
                    
                    <v-list dense rounded>
                    <v-virtual-scroll
                      :items="fetchedAfflicationData"
                      height="240"
                      item-height="42"
                    >
                      <template v-slot="{ item }">
                        <v-list-item :key="item.unit_id" @click = "setSelectedUnitIntoSignupData(item)">
                            <v-list-item-title>
                              {{item.unit_full_name}}
                            </v-list-item-title>
                        </v-list-item>
                      </template>
                    </v-virtual-scroll>
                  </v-list>
                  </v-menu>

                  
                </v-col>
              </v-row>
            </v-container>
            <h4>*은 필수 작성입니다</h4>
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
              @click="signup(signUpData);"
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
import axios from 'axios';
import {resourceHost} from '../store';

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
        name:"",
        unit_id:"",
        unit_full_name:"",
        email:"",
        phone:"",
      },

      fetchedAfflicationData:[],
    }),
    methods:{
      login(id,pw){
        this.$store.dispatch('login', {id, pw});
      },
      signup(data){
        this.showSignUpForm=false;
        if(data.password != data.password_again){
          this.$store.commit('pushAlert',{message:'패스워드가 일치하지 않습니다',type:'error'});
          return;
        }
        if(this.compareSelectedUnitWithInput() == -1){
          this.$store.commit('pushAlert',{message:'올바른 소속을 선택하지 않았습니다',type:'error'});
          return;
        }
        this.$store.dispatch('signup', data);
      },
      findAfflication(){
        axios(
            {
            method: 'post',
            url: `${resourceHost}/member/find_afflication`,
            data: {
              substring:this.signUpData.unit_full_name,
            }
          })
          .then((response)=>{
              if(response.status==200){
                this.fetchedAfflicationData = response.data.result;
              }
          }
        );
      },
      setSelectedUnitIntoSignupData(data){
        this.signUpData.unit_full_name = data.unit_full_name;
        this.signUpData.unit_id = data.unit_id;
      },
      compareSelectedUnitWithInput(){
        return this.fetchedAfflicationData.findIndex(d=>d.unit_full_name ===this.signUpData.unit_full_name)
      }
    }
}
</script>

<style>

</style>