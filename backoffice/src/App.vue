<template>
  <div>
    <router-view></router-view>
    <div class="v-application v-application--is-ltr">
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
    </div>
  </div>
</template>

<script>

export default {
  name: 'App',

  components: {
  },

  data: () => ({

  }),
  methods:{

  }
};
</script>
