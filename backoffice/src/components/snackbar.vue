<template>
  <v-snackbar
      v-model="render"
      :timeout="timeout"
    >
      {{ message }}
        <v-btn
          color="blue"
          text
          @click="render = false"
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
        render:false,timeout:2000,message:""
    }),
    methods:{
        showSnackBar(message,timeout){
            this.message=message;
            this.timeout=timeout;
            this.render=true;
        }
    },
}
</script>

<style>

</style>