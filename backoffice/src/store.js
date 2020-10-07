import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

const resourceHost = "https://spefor.ml/api/v1";

export const store = new Vuex.Store({
    state:{
        isAuthorized:false,
        tokenData:null,
        showSnackbar:true,
        snackbarMessage:"",
    },
    getters:{
        getIsAuthorized: function(state){
            return state.isAuthorized;
        },
        getTokenData: function(state){
            return state.tokenData;
        }
    },
    mutations:{
        showSnackbar(state,payload){
            state.showSnackbar = true;
            state.snackbarMessage = payload.message;
        },
        closeSnackbar(state){
            state.showSnackbar = false;
        },
        SetTokenData(state,payload){
            state.isAuthorized = true;
            state.tokenData = payload;
        },
        SetAuthorization(state){
            axios.defaults.headers.common['Authorization'] = `Bearer ${state.tokenData.access_token}`
        }
    },
    actions:{
        getUserCredentialWith({commit}, payload){
            axios(
                {
                method: 'post',
                url: `${resourceHost}/auth/login`,
                data: {
                  grant_type: 'password',
                  client_id: 'webapp',
                  user_id: payload.id,
                  password:payload.pw
                }
              })
              .then((response)=>{
                  if(response.status==200){
                    commit("SetTokenData",response.data);
                    commit("SetAuthorization");
                  }
                  else{
                    commit("showSnackbar",{message:"fdsa"});
                  }
              });
        },
        RegisterMemberWith({commit}, payload){
            axios(
                {
                method: 'post',
                url: `${resourceHost}/member/register`,
                data: {
                    user_id: payload.user_id,
                    password: payload.password,
                    cadre_flag: true,
                    army_num: payload.army_num,
                    unit_id: payload.unit_id,
                    email: payload.email,
                    phone: payload.phone,
                }
              })
              .then((response)=>{
                  if(response.status==200){
                    commit("showSnackbar",{message:"fdsa"});
                  }
              });
        }
    }
    
})