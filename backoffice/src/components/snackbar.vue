<template>
  <v-snackbar
    app
    :timeout="timeout"
    :value="this.$store.state.showSnackbar"
  >
    asdasdasdasda
    <v-btn
      color="blue"
      text
      @click="close()"
    >
      Close
    </v-btn>
  </v-snackbar>
</template>

<script>
export default {
    name:'snackbar',
    props:{
    },
    data:()=>({
        timeout:2000
    }),
    methods:{
      close(){
        this.$store.commit('closeSnackbar');
      }
    },
}
</script>

<style>

</style>