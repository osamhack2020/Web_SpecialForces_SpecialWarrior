<template>
  <v-app>
    <v-main>
      <loginpage v-if='!login' 
      :setLogin="setLogin" 
      :tokenData="tokenData"
      :getToken="getToken"
      />
      <mainpage v-if='login'/>
    </v-main>
     <snackbar ref="snackbar"/>
    <v-footer dark>
      <v-spacer></v-spacer>
      <div>&copy; {{ new Date().getFullYear() }}</div>
    </v-footer>
  </v-app>
</template>

<script>
import loginpage from './components/loginpage';
import mainpage from './components/mainpage';
import snackbar from './snackbar';
import axios from 'axios';

export default {
  name: 'App',

  components: {
    loginpage,mainpage,snackbar,
  },

  data: () => ({
    login:false,
    tokenData:{},
  }),
  methods:{
    showSnackbar(message,timeout){
      this.$refs.snackbar.showSnackbar(message,timeout);
    },
    setLogin(b){
      this.login = b;
    },
    getToken(user_id,password){
        axios(
          {
          method: 'post',
          url: 'https://spefor.ml/api/v1/auth/login',
          data: {
            grant_type: 'password',
            client_id: 'webapp',
            user_id:user_id,
            password:password,
          }
        })
        .then((response)=>{
          this.setLogin(true);
          this.tokenData = response.data;
        })
        .catch((error)=> {
          this.$refs.loginref.snackbar.showSnackbar("dddd",2000);
          console.log(error.response);
        })
      },
  }
};
</script>
