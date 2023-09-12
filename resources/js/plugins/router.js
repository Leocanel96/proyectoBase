import {createRouter, createWebHistory} from "vue-router";
import Home from '../pages/Home.vue'
import About from '../pages/About.vue'
import platillos from "../components/administrador/platillos.vue"
import usuarios from "../components/administrador/usuarios.vue"
import roles from "../components/administrador/roles.vue"
import cambioPass from "../components/personal/cambioPass.vue";

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/about',
        name: 'about',
        component: About
    },
    {
        path: '/platillos',
        name: 'platillos',
        component: platillos
    },
    {
        path: '/usuarios',
        name: 'usuarios',
        component: usuarios
    },
    {
        path: '/roles',
        name: 'roles',
        component: roles
    },
    {
        path: '/cambioPass',
        name: 'cambioPass',
        component: cambioPass
    }
]


const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
