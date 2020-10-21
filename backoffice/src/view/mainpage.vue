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
          <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
              <v-chip 
                small
                class="mr-1"
                @click="setMatched();getAccessibleUnit();"
                v-bind="attrs"
                v-on="on"
              >
                {{ $store.getters.getSelectedUnit.unit_full_name }}
                <v-icon>mdi-chevron-down</v-icon>
              </v-chip>
            </template>
            
            <v-list dense rounded>
              <v-list-item-group color="primary" v-model="test">
                <v-list-item
                  v-for="item in $store.getters.getAccessibleUnit"
                  :key="item.unit_id"
                  @click="$store.commit('SetSelectedUnit',item);"
                >
                  <v-list-item-title>{{item.unit_full_name}}</v-list-item-title>
                </v-list-item>
              </v-list-item-group>
            </v-list>
          </v-menu>
          <br>
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
                <v-list-item>
                <v-list-item-title>
                  <v-icon>mdi-bell</v-icon>
                  알림 로그
                </v-list-item-title>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <v-list-item
                  v-for="(item,index) in this.$store.state.alerts"
                  :key="index"
                  link
                  @click="$store.commit('closeAlert',index)"
                >
                <v-list-item-title>
                  <v-icon>mdi-exclamation-thick</v-icon>
                  {{ item.message }}
                </v-list-item-title>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <v-list-item
                  link
                  color="grey lighten-4"
                  @click="$store.commit('clearAlert');"
                >
                  <v-list-item-content>
                    <v-list-item-title>
                      <v-icon>mdi-delete-forever</v-icon>
                      모두 삭제
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
              <router-view></router-view>
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>

    <v-snackbar v-model="$store.getters.getSnackbar.show">
      {{ $store.getters.getSnackbar.message }}
      <template v-slot:action="{ attrs }">
        <v-btn
          color="pink"
          text
          v-bind="attrs"
          @click="$store.commit('closeSnackbar');"
        >
          닫기
        </v-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>

<script>
  export default {
    name:'mainpage',
    data: () => ({
      links: [
        {name:'병사관리',to:'/management'},
        {name:'모아보기',to:'/collection'},
        {name:'전사현황',to:'/warriorstatus'},
        {name:'FAQ',to:'/faq'},
        {name:'공지사항',to:'/notice'},
      ],
      test: 0,
    }),
    methods:{
      setMatched(){
        let matchingIndex = this.$store.getters.getAccessibleUnit.findIndex(d=>d.unit_id === this.$store.getters.getSelectedUnit.unit_id);
        this.test = matchingIndex;
      },
      getAccessibleUnit(){
        this.$store.dispatch('getAccessibleUnit');
      },
      logout(){
        this.$store.dispatch('logout');
      }
    },
  }
</script>

<style>

</style>