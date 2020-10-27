<template>
  <v-app id="inspire">
    <v-app-bar
      app
      :prominent="this.$vuetify.breakpoint.mdAndDown"
      dark
    >
      <v-container class="py-0 fill-height">
        <v-chip label color="white" text-color="black" class="mr-6" @click="$router.push('/')">
          <v-icon>
            mdi-arm-flex
          </v-icon>
          SpecialForces
        </v-chip>

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
          <v-menu offset-y dark>
            <template v-slot:activator="{ on, attrs }">
              <v-chip 
                small
                class="mr-1"
                @click="setMatched();getAccessibleUnit();"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon left>mdi-account-group</v-icon>
                {{ $store.getters.getSelectedUnit.unit_full_name }}
                <v-icon right>mdi-chevron-down</v-icon>
              </v-chip>
            </template>
            
            <v-list dense rounded>
              <v-list-item-group color="primary" v-model="test">
                <v-list-item
                  v-for="item in $store.getters.getAccessibleUnit"
                  :key="item.unit_id"
                  @click="$store.commit('SetSelectedUnit',item);"
                >
                  <v-list-item-title color="white">{{item.unit_full_name}}</v-list-item-title>
                </v-list-item>
              </v-list-item-group>
            </v-list>
          </v-menu>
          <br>
          <v-chip small class="mr-1"><v-icon>mdi-account</v-icon>{{ this.$store.getters.getUserData.name }}</v-chip>
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
                  <v-icon>mdi-help-box</v-icon>
                  도움요청
                </v-list-item-title>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <v-list-item
                  link
                >
                <v-list-item-title>
                  <v-icon>mdi-forum</v-icon>
                  관리자 채팅
                </v-list-item-title>
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
          color="primary"
          text
          v-bind="attrs"
          @click="$store.commit('closeSnackbar');"
        >
          닫기
        </v-btn>
      </template>
    </v-snackbar>
    <v-footer
      app
      absolute
      dark
      padless
      class="font-weight-medium"
    >
      <v-col
        class="text-center"
        cols="12"
      >
        {{ new Date().getFullYear() }} — <strong>SpecialWarrior</strong> — <router-link to="/opensource">오픈소스 라이센스</router-link>
      </v-col>
    </v-footer>
  </v-app>
</template>

<script>
  export default {
    name:'mainpage',
    data: () => ({
      links: [
        {name:'병사관리',to:'/management'},
        {name:'모아보기',to:'/collection'},
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