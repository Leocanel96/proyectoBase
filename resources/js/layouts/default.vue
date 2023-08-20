<template>
    <v-app id="inspire" class="panel-rutas">
        <v-navigation-drawer v-model="drawer">

            <v-img
                :width="300"
                aspect-ratio="16/9"
                cover
                src="../../../storage/img/logo.jpg"
            ></v-img>

            <v-list>
                <v-list-item
                    v-for="({text, route, icon}, index) in links"
                    :key="index"
                    :to="route"
                    :prepend-icon="icon"
                >
                    {{ text }}
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title>Proyecto Base</v-app-bar-title>
        </v-app-bar>

        <v-main>
            <slot></slot>
        </v-main>
    </v-app>
</template>

<script setup>
import {ref} from 'vue'

const drawer = ref(null)
const links = ref([
    {text: "Home", route: "/", icon: "mdi-home"},
    {text: "About", route: "/about", icon: "mdi-home"}
]);

</script>

<script>
import {ref} from "vue";

export default {
    data: () => ({drawer: null}),
}
</script>

<style>
.panel-rutas {
    background-color: #DDE2DC;
}

.imagenLogo {
    margin: auto;
    width: 100%;
    padding: 50px;
    font-family: 'Arial', sans-serif;
    color: #33475b;
}
</style>
