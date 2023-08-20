import './bootstrap';
import '../css/app.css'
import {createApp} from "vue";

import App from "./App.vue";
import router from "./plugins/router.js";
import vuetify from "./plugins/vuefify.js";


//install vue 3
const app = createApp(App)
app.use(router)
app.use(vuetify)
app.mount("#dasboard")


