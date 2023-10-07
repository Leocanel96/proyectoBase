<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialog"
                persistent
                width="800"
            >
                <v-form v-model="validDatos" @submit.prevent="agregarAsignacion">
                    <v-card>
                        <v-card-title>
                            <span class="text-h5">Agregar Permiso</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-autocomplete
                                            :items="itemsRoles"
                                            :custom-filter="buscarRoles"
                                            item-title="nombre_rol"
                                            :loading="loading"
                                            :rules="rolRule"
                                            v-model="rol"
                                            variant="underlined"
                                            label="Rol"
                                            hide-details
                                            hide-selected
                                            item-text="nombre_rol"
                                            solo
                                            return-object
                                        ></v-autocomplete>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-autocomplete
                                            :items="itemsPermisos"
                                            :custom-filter="buscarPermisos"
                                            item-title="nombre"
                                            :loading="loading"
                                            :rules="permisoRule"
                                            v-model="permiso"
                                            variant="underlined"
                                            label="Permiso"
                                            hide-details
                                            hide-selected
                                            item-text="nombre"
                                            solo
                                            return-object
                                        ></v-autocomplete>
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
                                @click="cerrarAgregarAsignacion"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                prepend-icon="mdi-content-save"
                                color="#1565C0"
                                class="text-none text-subtitle-1"
                                variant="flat"
                                @click="guardarAsignacion"
                                :disabled="!validDatos"
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
    name: "crearAsignacionPermisoRol",
    data: () => ({
        dialog: true,
        rol: '',
        permiso: '',
        //formulario
        validDatos: false,
        agregarAsignacion: false,

        //autocomplete1
        loading: false,
        itemsRoles: [],

        //autocomplete2
        loading2: false,
        itemsPermisos: [],

        // Reglas de las cajas de texto
        rolRule: [
            v => !!v || 'Rol es requerido.',
        ],
        permisoRule: [
            v => !!v || 'Permiso es requerido.',
        ],
    }),
    methods: {
        cerrarAgregarAsignacion() {
            this.$emit('cerrarNuevaAsignacion', null)
        },
        guardarAsignacion() {
            let asignacion = {
                rol: this.rol,
                permiso: this.permiso
            }

            axios.post('/guardarAsignacion', {
                datos: asignacion
            })
                .then(res => {
                    this.loading = false
                    this.$iziToast.success(res)
                    this.cerrarAgregarAsignacion()
                })
                .catch(err => {
                    this.$iziToast.error(err)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        buscarRoles(itemTitle, queryText, item) {
            const textOne = item.raw.nombre_rol.toLowerCase()
            const searchText = queryText.toLowerCase()
            return textOne.indexOf(searchText) > -1
        },

        buscarPermisos() {
            const textOne = item.raw.nombre.toLowerCase()
            const searchText = queryText.toLowerCase()
            return textOne.indexOf(searchText) > -1
        },
    },
    beforeCreate() {
        // Items have already been loaded
        axios.get('/obtenerRoles')
            .then(res => {
                this.loading = true
                this.itemsRoles = res.data.respuesta['roles']
                this.itemsPermisos = res.data.respuesta['permisos']
            })
            .catch(err => {
                this.loading = false
            })
            .finally(() => {
                this.loading = false
            })
    }
}
</script>
<style scoped>

</style>
