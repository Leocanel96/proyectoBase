import './bootstrap';
import '../css/app.css'
import {createApp} from "vue";

import App from "./App.vue";
import router from "./plugins/router.js";
import vuetify from "./plugins/vuefify.js";
import msj from "./plugins/msj.js";

//install vue 3
const app = createApp(App)
app.use(router)
app.use(vuetify)
app.use(msj)
app.mount("#dasboard")


