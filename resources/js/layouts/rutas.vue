<template>
    <v-card>
        <v-list v-model:opened="open">
            <v-list-group value="Administrador">
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        prepend-icon="mdi-security"
                        title="Administrador"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="({text, route, icon}, index) in links"
                    :key="index"
                    :to="route"
                    :value="text"
                    :title="text"
                    :prepend-icon="icon"
                ></v-list-item>
            </v-list-group>


            <!--            Ruta de Sistema-->
            <v-list-group value="Sistema">
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        prepend-icon="mdi-logout"
                        title="Sistema"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="({text, route, icon}, index) in sistema"
                    :key="index"
                    :to="route"
                    :value="text"
                    :title="text"
                    :prepend-icon="icon"
                ></v-list-item>
            </v-list-group>


            <!--            Ruta de personal-->
            <v-list-group value="Personal">
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        prepend-icon="mdi-account-circle"
                        title="Personal"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="({text, route, icon}, index) in personal"
                    :key="index"
                    :to="route"
                    :value="text"
                    :title="text"
                    :prepend-icon="icon"
                ></v-list-item>
            </v-list-group>
        </v-list>
    </v-card>
</template>

<script>
export default {
    name: "rutas",
    data: () => ({
        open: ['Administrador'],
        links: [
            {text: "Platillos", route: "/platillos", icon: "mdi-chef-hat"},
            {text: "Usuarios", route: "/usuarios", icon: "mdi-account"},
            {text: "Roles", route: "/roles", icon: "mdi-account-switch"},
        ],
        sistema: [
            {text: "Cerrar Sesión", route: "/cerrarSesion", icon: "mdi-account-key-outline"}
        ],
        personal: [
            {text: "Cambiar contraseña", route: "/cambioPass", icon: "mdi-lock-reset"}
        ],
    }),
}
</script>

<style scoped>

</style>
