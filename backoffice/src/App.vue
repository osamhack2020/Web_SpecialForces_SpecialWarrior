<template>
  <v-app>
    <v-main>
      <loginpage v-if='!this.$store.state.isAuthorized'/>
      <mainpage v-if='this.$store.state.isAuthorized'/>
    </v-main>
     <snackbar v-if="this.$store.state.showSnackbar"/>
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
    loginpage,mainpage
  },

  data: () => ({

  }),
  methods:{

  }
};
</script>
