import './bootstrap';
import '../css/app.css'
import {createApp} from "vue/dist/vue.esm-bundler.js";

import workarea from "./App.vue";
import router from "./plugins/router.js";
import vuetify from "./plugins/vuefify.js";
import msj from "./plugins/msj.js";
import login from "./components/login/login.vue"
//install vue 3
const app = createApp({})
app.use(router)
app.use(vuetify)
app.use(msj)
app.component('workarea', workarea)
app.component('login', login)
app.mount("#dasboard")



