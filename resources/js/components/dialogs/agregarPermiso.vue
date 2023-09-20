<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialogEditarPlatillo"
                persistent
                width="800"
            >
                <v-form v-model="validDatos" @submit.prevent="agregarPlatillo">
                    <v-card>
                        <v-card-title>
                            <span class="text-h5 font-weight-black">Asignar permisos</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-card-subtitle><b>Permisos disponibles</b></v-card-subtitle>
                                        <v-hover
                                            v-slot="{ isHovering, props }"
                                            open-delay="200"
                                        >
                                            <v-card
                                                :elevation="isHovering ? 16 : 2"
                                                :class="{ 'on-hover': isHovering }"
                                                class="mx-auto"
                                                height="600"
                                                max-width="350"
                                                v-bind="props"
                                            >
                                                <v-card-text class="font-weight-medium mt-12 text-center text-subtitle-1">
                                                    <span style="margin-top: 5%"><b>Administrador</b></span>
                                                    <hr>
                                                    <v-switch
                                                        v-for="permiso in permisosAdministrador"
                                                        :key="permiso.id"
                                                        :model-value="permiso.value"
                                                        :label="permiso.nombre"
                                                        color="#01579B"
                                                        @click="agregarPermiso(permiso)"
                                                    ></v-switch>
                                                    <span style="margin-top: 5%"><b>Sistema</b></span>
                                                    <hr>
                                                    <v-switch
                                                        v-for="permiso in permisosSistema"
                                                        :key="permiso.id"
                                                        :label="permiso.nombre"
                                                        color="#01579B"
                                                        :model-value="permiso.value"
                                                        hide-details
                                                        @click="agregarPermiso(permiso)"
                                                    ></v-switch>
                                                    <span style="margin-top: 5%"><b>Personal</b></span>
                                                    <hr>
                                                    <v-switch
                                                        v-for="permiso in permisosPersonal"
                                                        :key="permiso.id"
                                                        :model-value="permiso.value"
                                                        :label="permiso.nombre"
                                                        color="#01579B"
                                                        hide-details
                                                        @click="agregarPermiso(permiso)"
                                                    ></v-switch>
                                                </v-card-text>
                                            </v-card>
                                        </v-hover>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-card-subtitle>Permisos agregados</v-card-subtitle>
                                        <v-hover
                                            v-slot="{ isHovering, props }"
                                            close-delay="200"
                                        >
                                            <v-card
                                                :elevation="isHovering ? 16 : 2"
                                                :class="{ 'on-hover': isHovering }"
                                                class="mx-auto"
                                                height="500"
                                                max-width="350"
                                                v-bind="props"
                                            >
                                                <v-card-text class="font-weight-medium mt-12 text-center text-subtitle-1">
                                                    <v-card
                                                        class="mx-auto"
                                                        max-width="500"
                                                    >
                                                        <v-col
                                                            v-for="(permiso, index) in permisosAlmacenar"
                                                            :key="permiso.nombre"
                                                        >
                                                            <v-chip
                                                                class="ma-2"
                                                                closable
                                                                @click:close="eliminarPermiso(permiso, index)"
                                                            >
                                                                <v-icon start :icon="permiso.icon"></v-icon>
                                                                {{ permiso.nombre }}
                                                            </v-chip>
                                                        </v-col>


                                                    </v-card>
                                                </v-card-text>
                                            </v-card>
                                        </v-hover>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                prepend-icon="mdi-cancel"
                                color="#DD2C00"
                                class="text-none text-subtitle-1"
                                variant="flat"
                                @click="cerrarAsignarPermisos"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                prepend-icon="mdi-content-save"
                                color="#1565C0"
                                class="text-none text-subtitle-1"
                                variant="flat"
                                :disabled="!validDatos"
                                @click="guardarPermisosAgregados "
                            >
                                Guardar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-row>
    </template>
</template>
<script>
export default {
    name: "agregarPermiso",
    data: () => ({
        dialogEditarPlatillo: true,
        //autocomplete
        loading: false,
        // items: [],
        //formulario
        validDatos: false,
        agregarPlatillo: false,

        platilloEditado: [],
        platillos: false,
        usuarios: false,
        roles: false,
        permisos: false,
        cerrarSesion: false,
        cambiarPass: false,
        permisosAdministrador: [
            {
                id: 1,
                nombre: 'Platillos',
                value: 'false',
                icon: 'mdi-noodles'
            },
            {
                id: 2,
                nombre: 'Usuarios',
                value: 'false',
                icon: 'mdi-account'
            },
            {
                id: 3,
                nombre: 'Roles',
                value: 'false',
                icon: 'mdi-account-child'
            },
            {
                id: 4,
                nombre: 'Permisos',
                value: 'false',
                icon: 'mdi-key-chain'

            },
        ],
        permisosSistema: [
            {
                id: 1,
                nombre: 'Cerrar Sessión',
                value: 'false',
                icon: 'mdi-logout-variant'
            },
        ],
        permisosPersonal: [
            {
                id: 1,
                nombre: 'Cambiar contraseña',
                value: 'false',
                icon: 'mdi-lock-reset'
            }
        ],
        permisosAlmacenar: [],
        permisosAlmacenarAdministrador: [],
        permisosAlmacenarSistema: [],
        permisosAlmacenarPersonal: [],
    }),
    methods: {
        agregarPermiso(permiso) {
            if (this.platillos === false && permiso.nombre == 'Platillos') {
                permiso.value = true
                this.permisosAdministrador[0]['value'] = true
                this.permisosAlmacenar.push(permiso)
                this.permisosAlmacenarAdministrador.push(permiso)
                this.platillos = true
                this.$iziToast.info("Listo", 'Permiso asignado.')
            }

            if (this.usuarios == false && permiso.nombre == 'Usuarios') {
                permiso.value = true
                this.permisosAdministrador[1]['value'] = true
                this.permisosAlmacenar.push(permiso)
                this.permisosAlmacenarAdministrador.push(permiso)
                this.usuarios = true
                this.$iziToast.info("Listo", 'Permiso asignado.')
            }

            if (this.roles == false && permiso.nombre == 'Roles') {
                permiso.value = true
                this.permisosAdministrador[2]['value'] = true
                this.permisosAlmacenar.push(permiso)
                this.permisosAlmacenarAdministrador.push(permiso)
                this.roles = true
                this.$iziToast.info("Listo", 'Permiso asignado.')
            }

            if (this.permisos == false && permiso.nombre == 'Permisos') {
                permiso.value = true
                this.permisosAdministrador[3]['value'] = true
                this.permisosAlmacenar.push(permiso)
                this.permisosAlmacenarAdministrador.push(permiso)
                this.permisos = true
                this.$iziToast.info("Listo", 'Permiso asignado.')
            }

            if (this.cerrarSesion == false && permiso.nombre == 'Cerrar Sessión') {
                permiso.value = true
                this.permisosSistema[0]['value'] = true
                this.permisosAlmacenar.push(permiso)
                this.permisosAlmacenarSistema.push(permiso)
                this.cerrarSesion = true
                this.$iziToast.info("Listo", 'Permiso asignado.')
            }

            if (this.cambiarPass == false && permiso.nombre == 'Cambiar contraseña') {
                permiso.value = true
                this.permisosPersonal[0]['value'] = true
                this.permisosAlmacenar.push(permiso)
                this.permisosAlmacenarPersonal.push(permiso)
                this.cambiarPass = true
                this.$iziToast.info("Listo", 'Permiso asignado.')
            }
        },

        eliminarPermiso(permiso, index) {
            if (this.platillos === true && permiso.nombre == 'Platillos') {
                this.permisosAlmacenar.splice(index, 1)
                this.platillos = false
                this.permisosAdministrador[0]['value'] = false
                this.$iziToast.info("Listo", 'Permiso retirado.')
            }

            if (this.usuarios == true && permiso.nombre == 'Usuarios') {
                this.permisosAlmacenar.splice(index, 1)
                this.usuarios = false
                this.permisosAdministrador[1]['value'] = false
                this.$iziToast.info("Listo", 'Permiso retirado.')
            }

            if (this.roles == true && permiso.nombre == 'Roles') {
                this.permisosAlmacenar.splice(index, 1)
                this.roles = false
                this.permisosAdministrador[2]['value'] = false
                this.$iziToast.info("Listo", 'Permiso retirado.')
            }

            if (this.permisos == true && permiso.nombre == 'Permisos') {
                this.permisosAlmacenar.splice(index, 1)
                this.permisos = false
                this.permisosAdministrador[3]['value'] = false
                this.$iziToast.info("Listo", 'Permiso retirado.')
            }

            if (this.cerrarSesion == true && permiso.nombre == 'Cerrar Sessión') {
                this.permisosAlmacenar.splice(index, 1)
                this.cerrarSesion = false
                this.permisosSistema[0]['value'] = false
                this.$iziToast.info("Listo", 'Permiso retirado.')
            }

            if (this.cambiarPass == true && permiso.nombre == 'Cambiar contraseña') {
                this.permisosAlmacenar.splice(index, 1)
                this.cambiarPass = false
                this.permisosPersonal[0]['value'] = false
                this.$iziToast.info("Listo", 'Permiso retirado.')
            }
        },

        cerrarAsignarPermisos() {
            this.$emit('cerrarAgregarPermiso')
        },
        guardarPermisosAgregados() {
            let permisosAgregados = {
                administrador: this.permisosAlmacenarAdministrador,
                sistema: this.permisosAlmacenarSistema,
                personal: this.permisosAlmacenarPersonal,
                idEditar: this.enviarAgregarPermiso['id_permiso']
            }

            axios.post('/guardarPermisosAgregados', {
                datos: permisosAgregados
            })
                .then(res => {
                    this.loading = false
                    this.$iziToast.success(res)
                    this.cerrarAsignarPermisos()
                })
                .catch(err => {
                    this.$iziToast.error(err)
                })
                .finally(() => {
                    this.loading = false
                })
        },
    },
    beforeCreate() {
        console.log(JSON.stringify(this.enviarAgregarPermiso, null, 2))
    },
    props: {
        enviarAgregarPermiso: {
            id_permiso: Number,
            nombre_permiso: String,
            permisos_creados: String
        }
    }
}
</script>


<style scoped>

</style>
