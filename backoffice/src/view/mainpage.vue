<template>
  <v-app id="inspire">
    <v-app-bar
      app
      color="white"
      flat
    >
      <v-container class="py-0 fill-height">
        <v-avatar
          class="mr-10"
          color="grey darken-1"
          size="32"
        ></v-avatar>

        <v-btn
          v-for="link in links"
          :key="link.name"
          text
          :to="link.to"
        >
          {{ link.name }}
        </v-btn>

        <v-spacer></v-spacer>

        <v-responsive align="right">
            <!-- <v-menu offset-y>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="primary"
                  dark
                  v-bind="attrs"
                  v-on="on"
                >
                  Dropdown
                </v-btn>
              </template>
              <v-list>
                <v-list-item
                  v-for="(item, index) in items"
                  :key="index"
                >
                  <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu> -->
              <v-chip small class="mr-1">{{ this.$store.getters.getUserData.unit_name }} <v-icon>mdi-chevron-down</v-icon></v-chip><br>
              <v-chip small class="mr-1">{{ this.$store.getters.getUserData.name }}</v-chip>
              <v-chip small class="mr-1" @click="logout()"><v-icon>mdi-power</v-icon>로그아웃</v-chip>
        </v-responsive>
      </v-container>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row>
          <v-col cols="2">
            <v-sheet rounded="lg">
              <v-list color="transparent">
                <v-list-item
                  v-for="n in 5"
                  :key="n"
                  link
                >
                  <v-list-item-content>
                    <v-list-item-title>
                      List Item {{ n }}
                    </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <v-list-item
                  link
                  color="grey lighten-4"
                >
                  <v-list-item-content>
                    <v-list-item-title>
                      Refresh
                    </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-sheet>
          </v-col>

          <v-col>
            <v-sheet
              min-height="70vh"
              rounded="lg"
            >
              <!--  -->
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import axios from 'axios';
import {store} from '../store';
  export default {
    name:'mainpage',
    data: () => ({
      links: [
        {name:'병사관리',to:'/management'},
        {name:'모아보기',to:'/collection'},
        {name:'전사현황',to:'/statusmanagement'},
        {name:'FAQ',to:'/faq'},
        {name:'공지사항',to:'/notice'},
      ],
      accessibleUnit:{},
    }),
    methods:{
      getAccessibleUnit(){
        axios(
          {
          method: 'get',
          url: `${store.resourceHost}/cadre/get_warriors`,
        })
        .then((response)=>{
            if(response.status==200){
              this.accessibleUnit = response.data;
            }
        });
      },
      logout(){
        this.$store.dispatch('logout');
      }
    },
  }
</script>

<style>

</style>