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
        <v-btn block>
          Login
        </v-btn>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
    name:'loginpage',

    data: () => ({
      id:null,pw:null,

    }),
}
</script>

<style>

</style>