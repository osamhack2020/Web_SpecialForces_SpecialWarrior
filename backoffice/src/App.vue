<template>
  <v-app>
    <loginpage v-if='!this.$store.state.isAuthorized'/>
    <mainpage v-if='this.$store.state.isAuthorized' />
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
