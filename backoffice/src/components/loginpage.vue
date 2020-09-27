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
        solo
        dense
        color="deep-purple"
        label="ID"
      ></v-text-field>
      <v-text-field
        v-model="pw"
        solo
        dense
        color="deep-purple"
        label="PASSWORD"
        type="password"
      ></v-text-field>
        <v-btn block @click="getToken(id,pw)">
          Login
        </v-btn>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>


export default {
    name:'loginpage',
    props: {
      setLogin: {type: Function},
      getToken: {type: Function},
    },
    data: () => ({
      id:"",pw:"",
      showError:true,errorMsg:"asd",
    }),
    methods:{
      
    }
}
</script>

<style>

</style>