<template>
  <v-snackbar
      v-model="this.$store.state.showSnackbar"
      :timeout="timeout"
    >
      {{ this.$store.state.snackbarMessage }}
        <v-btn
          color="blue"
          text
          @click="this.$store.state.showSnackbar = false"
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

    },
}
</script>

<style>

</style>