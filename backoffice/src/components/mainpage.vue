<template>
    <v-app>
      <v-container>
        mainpage

        {{ this.$store.state.userData }}
      </v-container>
    </v-app>
</template>

<script>
export default {
    name:'mainpage',
    components:{
    },
    data:() => ({
        drawer: false,
    }),
}
</script>

<style>

</style>