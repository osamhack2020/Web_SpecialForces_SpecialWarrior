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
        clearable
        clear-icon="mdi-close-circle"
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
        <v-btn dark block @click="login(id,pw)">
          Login
        </v-btn>
        <v-btn dark block @click="login(id,pw)">
          Register
        </v-btn>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>


export default {
    name:'loginpage',
    data: () => ({
      id:"",pw:"",
    }),
    methods:{
      login(id,pw){
        this.$store.dispatch('getUserCredentialWith', {id, pw});
      },
    }
}
</script>

<style>

</style>