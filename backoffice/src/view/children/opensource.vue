<template>
    <v-app>
    <v-dialog
      v-model="dialog"
      persistent
      fullscreen
    >
      <v-card>
        <v-toolbar dark>
          <v-btn
            icon
            @click="closeDialog()"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>오픈소스 라이센스</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
        <v-container>
          <v-row>
            <v-col
            cols="6"
            v-for="(item,index) in opensource.names"
            :key="index">
          <v-card>            
            <v-card-title>
              <v-avatar
                color="grey lighten-3"
                size="56"
                rounded
                class="elevation-2 mr-3"
              >
                <v-img :src="opensource.images[index]" ></v-img>
              </v-avatar>
              {{item}}
            </v-card-title>

            <v-card-actions>
              <v-btn
                color="primary"
                text
                @click="opened=(opened==index)?-1:index"
              >
                라이센스 보기
              </v-btn>
              <v-btn
                color="primary"
                icon
                :href="opensource.homepages[index]"
                target="_blank"
              >
                <v-icon color="primary">mdi-open-in-new</v-icon>
              </v-btn>
            </v-card-actions>

            <v-expand-transition>
              <div v-show="opened==index">
                <v-divider></v-divider>

                <v-card-text v-html="opensource.licenses[index]">
                  
                </v-card-text>
              </div>
            </v-expand-transition>
          </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-dialog>
    </v-app>
</template>

<script>
const license = {
  MIT(years,author){return "The MIT License (MIT)<br>\
<br>\
Copyright (c) "+years+", "+author+"<br>\
<br>\
Permission is hereby granted, free of charge, to any person obtaining a copy<br>\
of this software and associated documentation files (the &quot;Software&quot;), to deal<br>\
in the Software without restriction, including without limitation the rights<br>\
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell<br>\
copies of the Software, and to permit persons to whom the Software is<br>\
furnished to do so, subject to the following conditions:<br>\
<br>\
The above copyright notice and this permission notice shall be included in<br>\
all copies or substantial portions of the Software.<br>\
<br>\
THE SOFTWARE IS PROVIDED &quot;AS IS&quot;, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR<br>\
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,<br>\
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE<br>\
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER<br>\
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,<br>\
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN<br>\
THE SOFTWARE."},
}
export default {
    name:'opensource',
    data:()=>({
        dialog:true,
        opensource:{
          names:["vue.js","vue-router","vue-cli","vuex","vuetify","axios"],
          licenses:[
            license.MIT("2013-present","Yuxi (Evan) You"),
            license.MIT("2013-present","Evan You"),
            license.MIT("2017-present","Yuxi (Evan) You"),
            license.MIT("2015-present","Evan You"),
            license.MIT("2016-2020","John Jeremy Leider"),
            license.MIT("2014-present","Matt Zabriskie"),
          ],
          homepages:[
            "https://github.com/vuejs/vue",
            "https://github.com/vuejs/vue-router",
            "https://github.com/vuejs/vue-cli",
            "https://github.com/vuejs/vuex",
            "https://github.com/vuetifyjs/vuetify",
            "https://github.com/axios/axios",
          ],
          images:[
            "https://vuejs.org/images/logo.png",
            "https://vuejs.org/images/logo.png",
            "https://vuejs.org/images/logo.png",
            "https://vuejs.org/images/logo.png",
            "https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-dark.svg",
          ]
        },
        opened:-1,
    }),
    methods:{
        closeDialog(){
            this.dialog=false;
            this.$router.push('/');
        }
    }

}
</script>

<style>

</style>