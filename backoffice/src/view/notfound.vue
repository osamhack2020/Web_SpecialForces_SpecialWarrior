<template>
    <v-app >
        <v-container fill-height class="text-center" align="center">
            <v-card class="text-center mx-auto pa-5">
                <v-card-title>
                    Error
                </v-card-title>
                <v-card-subtitle>
                    PAGE NOT FOUND
                </v-card-subtitle>
                <v-card-text>
                <v-icon>mdi-emoticon-frown</v-icon>
                </v-card-text>
                <v-btn to="/" block>
                    <v-icon>mdi-home</v-icon>
                </v-btn>
            </v-card>
        </v-container>
    </v-app>
</template>

<script>
export default {
    name:'notfound',
    data:()=>({

    }),
}
</script>

<style>

</style>