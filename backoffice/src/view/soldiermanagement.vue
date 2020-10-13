<template>
    <v-card>
        {{ warriors }}
    </v-card>
</template>

<script>
export default {
    name:'soldiermanagement',
    data:()=>({
        warriors:'',
    }),
    methods:{
        getWarriors(){
            axios(
                {
                method: 'get',
                url: `${resourceHost}/cadre/get_warriors`,
              })
              .then((response)=>{
                  if(response.status==200){
                    warriors = response.data;
                  }
              });
        }
    },
}
</script>

<style>

</style>