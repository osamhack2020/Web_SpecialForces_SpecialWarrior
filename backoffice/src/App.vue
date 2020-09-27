<template>
  <v-app>
    <v-main>
      <loginpage v-if='!login'/>
      <mainpage v-if='login'/>
    </v-main>
    
    <v-footer dark>
      <v-spacer></v-spacer>
      <div>&copy; {{ new Date().getFullYear() }}</div>
    </v-footer>
  </v-app>
</template>

<script>
import loginpage from './components/loginpage';
import mainpage from './components/mainpage';

export default {
  name: 'App',

  components: {
    loginpage,mainpage,
  },

  data: () => ({
    login:false,

  }),
};
</script>
