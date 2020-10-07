<template>
    <v-container>
        <v-card>
            <v-app-bar
                color="blue lighten-2"
                elevate-on-scroll>
                <v-app-bar-nav-icon dark @click="drawer= !drawer"></v-app-bar-nav-icon>
                <v-tabs
                  v-model="tab"
                  fixed-tabs
                  dark
                >
                  <v-tabs-slider></v-tabs-slider>

                  <v-tab
                    v-for="menu in menus"
                    :key="menu"
                  >
                    {{ menu }}
                  </v-tab>
                </v-tabs>
            </v-app-bar>
        </v-card>
        <!-- <v-app-bar
            color="blue lighten-2"
            elevate-on-scroll
        >
          <v-app-bar-nav-icon></v-app-bar-nav-icon>

          <v-toolbar-title>Title</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon>
            <v-icon>mdi-magnify</v-icon>
          </v-btn>

          <v-btn icon>
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </v-app-bar> -->
        <v-tabs-items v-model="tab">
          <v-tab-item
            v-for="menu in menus"
            :key="menu"
          >
            <v-card flat>
                <soldiermanagement v-if="tab==0"/>
            </v-card>
          </v-tab-item>
        </v-tabs-items>
        <!-- <v-footer dark app>
            <v-spacer></v-spacer>
          <div>&copy; {{ new Date().getFullYear() }}</div>
        </v-footer> -->
    </v-container>
</template>

<script>
import soldiermanagement from './soldiermanagement.vue';
export default {
    name:'mainpage',
    components:{
        soldiermanagement,
    },
    data:() => ({
        drawer: false,
        tab: null,
        text:"asd",
        menus: [
          '병사관리', '모아보기', '전사현황', 'FAQ', '공지사항',
        ],
    }),
}
</script>

<style>

</style>