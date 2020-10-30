import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import router from './routes/index.js';

Vue.use(Vuex);

export const resourceHost = "https://spefor.ml/api/v1";
const localTokenData = JSON.parse(localStorage.getItem('tokenData'));
const initialState = localTokenData?  localTokenData : null;

const localUserData = JSON.parse(localStorage.getItem('userData'));
const initialUserData = localUserData?  localUserData : null;

function SaveToken(state){
    localStorage.setItem('tokenData',JSON.stringify(state.tokenData));
}
function SaveUser(state){
    localStorage.setItem('userData',JSON.stringify(state.userData));
}
function ClearToken(){
    localStorage.removeItem('tokenData');
}
function ClearUser(){
    localStorage.removeItem('userData');
}

const axiosInterceptor = axios.interceptors.response.use(
    function (response) {
        //status == 200
        return response;
    },

    function (error) {
        //status != 200
        
        if(error.response.data.error){ //FROM AUTH Process
            if( error.response.data.error_description.indexOf("expired") != -1 ){
                //Needs Refresh
                return store.dispatch('refreshToken')
                .then(()=>{
                    error.config.headers['Authorization'] = `Bearer ${store.getters.getTokenData.access_token}`;
                    return axios.request(error.config);
                });
            }
            else if(error.response.data.error_description.indexOf("invalid") != -1){
                //Refresh Token expired, too
                store.dispatch('logout');
                return;
            }
            else
            store.commit('showSnackbar',{message:error.response.data.error_description});
        }
        else{ //FROM API
            if(error.response.data.message.indexOf("간부만 접근할 수 있습니다") != -1){
                //Refresh Token expired, too
                store.dispatch('logout');
            }
            store.commit('showSnackbar',{message:error.response.data.message});
        }

        return Promise.reject(error);
    }
);
axiosInterceptor;

export const store = new Vuex.Store({
    state:{
        //Auth
        userData:initialUserData,
        tokenData:initialState,
        
        //Alert
        alerts:[],

        //Snackbar
        snackbar:{message:"",show:false},
        
        //UnitSelection
        accessibleUnit:null,
        selectedUnit:null,

        //Notice
        isNoticeNeedRefresh:false,

        //FAQ
        isFaqNeedRefresh:false,
    },
    getters:{
        getTokenData: function(state){
            return state.tokenData;
        },
        getUserData: function(state){
            return state.userData;
        },
        getAccessibleUnit:function(state){
            return state.accessibleUnit;
        },
        getSelectedUnit:function(state){
            return state.selectedUnit;
        },
        getIsNoticeNeedRefresh: function(state){
            return state.isNoticeNeedRefresh;
        },
        getIsFaqNeedRefresh: function(state){
            return state.isFaqNeedRefresh;
        },
        getSnackbar: function(state){
            return state.snackbar;
        }
    },
    mutations:{
        //Auth
        OnLoginSuccess(){
            this.commit('SetAuthorization');
        },
        AfterLoginSuccess(state){
            this.dispatch("getAccessibleUnit");
            this.commit("SetSelectedUnit",{unit_full_name:state.userData.unit_full_name, unit_id:state.userData.unit_id});
            this.commit("clearAlert");
        },
        OnLogout(){
            this.commit("clearAlert");
            router.push('/login');
        },
        SetTokenData(state,payload){
            state.tokenData = payload;
            SaveToken(state);
        },
        UnsetTokenData(state){
            state.tokenData = null;
            ClearToken();
        },
        SetUserData(state,payload){
            state.userData = payload;
            SaveUser(state);
        },
        UnsetUserData(state){
            state.userData = null;
            ClearUser();
        },
        SetAuthorization(state){
            axios.defaults.headers.common['Authorization'] = `Bearer ${state.tokenData.access_token}`
        },

        //Alert
        pushAlert(state,payload){
            state.alerts.push({message:payload.message,type:payload.type});
            this.commit('showSnackbar',{message:payload.message});
        },
        closeAlert(state,payload){
            state.alerts.splice(payload,1);
        },
        clearAlert(state){
            state.alerts=[];
        },

        //Snackbar
        showSnackbar(state,payload){
            state.snackbar.message=payload.message;
            state.snackbar.show=true;
        },
        closeSnackbar(state){
            state.snackbar.show=false;
        },

        //UnitSelection
        SetAccessibleUnit(state,payload){
            state.accessibleUnit = payload;
        },
        SetSelectedUnit(state,payload){
            state.selectedUnit = payload;
        },

        //Notice
        SetNoticeRefresh(state,payload){
            state.isNoticeNeedRefresh = payload;
        },
        //FAQ
        SetFaqRefresh(state,payload){
            state.isFaqNeedRefresh = payload;
        },
    },
    actions:{
        fetchUser({commit}){
            return axios(
                {
                method: 'get',
                url: `${resourceHost}/member/get_userinfo`,
              })
              .then((response)=>{
                  if(response.status==200){
                    commit("SetUserData",response.data.result[0]);
                    commit("AfterLoginSuccess");
                    router.push('/');
                  }
              });
        },
        login({commit}, payload){
            return axios(
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
                    commit('OnLoginSuccess');
                    this.dispatch('fetchUser');
                  }
              });
        },
        refreshToken({commit}){
            return axios(
                {
                method: 'post',
                url: `${resourceHost}/auth/login`,
                data: {
                  grant_type: 'refresh_token',
                  client_id: 'webapp',
                  refresh_token: this.getters.getTokenData.refresh_token
                }
              })
              .then((response)=>{
                  if(response.status==200){
                    commit("SetTokenData",response.data);
                    commit('OnLoginSuccess');
                  }
              });
        },
        logout({commit}){
            commit('UnsetTokenData');
            commit('UnsetUserData');
            commit('OnLogout');
        },
        signup({commit}, payload){
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
                    name:payload.name,
                    email: payload.email,
                    phone: payload.phone,
                }
              })
              .then((response)=>{
                  if(response.status==200){
                    commit("showSnackbar",{message:response.data.message});
                    alert(JSON.stringify(response));
                  }
              });
        },
        getAccessibleUnit({commit}){
            axios(
              {
              method: 'get',
              url: `${resourceHost}/cadre/get_accessible_unit`,
            })
            .then((response)=>{
                if(response.status==200){
                  commit('SetAccessibleUnit',response.data.result[0]);
                }
            });
          },
    }
    
})