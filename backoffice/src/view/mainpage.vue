<template>
  <v-app id="inspire">
    <v-navigation-drawer
      app
      dark
    >
      <v-sheet
        class="pa-4 text-center"
      >
        <v-btn color="white" block class="mb-4" style="color:black" @click="$router.push('/')">
          <v-icon>
            mdi-arm-flex
          </v-icon>
          SpecialForces
        </v-btn>
        
        <div>
          <v-menu offset-y dark>
            <template v-slot:activator="{ on, attrs }">
              <v-card color="secondary">
                
                <span class="text-subtitle-2">{{ $store.getters.getSelectedUnit.unit_full_name }}</span>
      
                <v-btn
                block
                color="primary"
                @click="setMatched();getAccessibleUnit();"
                v-bind="attrs"
                v-on="on"
              >
              <v-icon left>mdi-account-group</v-icon>
                변경
                <v-icon right>mdi-chevron-down</v-icon>
              </v-btn>
              </v-card>
              
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
          <div class="mt-4">
          <v-chip class="mr-1"><v-icon>mdi-account</v-icon>{{ this.$store.getters.getUserData.name }}</v-chip>
          <v-chip class="mr-1" @click="logout()"><v-icon>mdi-power</v-icon>로그아웃</v-chip>
          </div>
        </div>
      </v-sheet>

      <v-divider></v-divider>

      <v-list rounded>
        <v-list-item
          v-for="item in links"
          :key="item.name"
          link
          :to="item.to"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.name }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-main class="grey lighten-2">
      <v-container>
        <v-sheet
          min-height="70vh"
          rounded
        >
          <router-view></router-view>
        </v-sheet>
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
        {icon:'mdi-clipboard-account',name:'병사관리',to:'/management'},
        {icon:'mdi-view-dashboard',name:'모아보기',to:'/collection'},
        {icon:'mdi-clipboard-list',name:'전사현황',to:'/warriorstatus'},
        {icon:'mdi-frequently-asked-questions',name:'FAQ',to:'/faq'},
        {icon:'mdi-information',name:'공지사항',to:'/notice'},
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