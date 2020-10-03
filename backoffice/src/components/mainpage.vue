<template>
    <v-container>
        <v-app-bar>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-tabs align-with-title fixed-tabs>
              <v-tab>Tab 1</v-tab>
              <v-tab>Tab 2</v-tab>
              <v-tab>Tab 3</v-tab>
              <v-tab>Tab 4</v-tab>
              <v-tab>Tab 5</v-tab>
              <v-tab>Tab 6</v-tab>
            </v-tabs>
        </v-app-bar>
        <v-main>
            asdadsa
        </v-main>
        <!-- <v-footer dark app>
            <v-spacer></v-spacer>
          <div>&copy; {{ new Date().getFullYear() }}</div>
        </v-footer> -->
    </v-container>
</template>

<script>
export default {
    name:'mainpage',
    data:() => ({
        items: [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2' },
      ],
    }),
}
</script>

<style>

</style>