<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialogEditarAsignacion"
                persistent
                width="800"
            >
                <v-form v-model="validDatos" @submit.prevent="editarAsignacion">
                    <v-card>
                        <v-card-title>
                            <span class="text-h5 font-weight-black">Editar Asignación</span>
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
                                            v-model="asignacionEditada.nombre_rol"
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
                                            v-model="asignacionEditada.nombre"
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
                                @click="cerrarEditarAsignacion"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                prepend-icon="mdi-content-save"
                                color="#1565C0"
                                class="text-none text-subtitle-1"
                                variant="flat"
                                :disabled="!validDatos"
                                @click="guardarAsignacionEditada"
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
    name: "editarAsignacion",
    data: () => ({
        dialogEditarAsignacion: true,

        //formulario
        validDatos: false,
        editarAsignacion: false,

        //autocomplete1
        loading: false,
        itemsRoles: [],

        //autocomplete2
        loading2: false,
        itemsPermisos: [],

        asignacionEditada: [],
        // Reglas de las cajas de texto
        rolRule: [
            v => !!v || 'Rol es requerido.',
        ],
        permisoRule: [
            v => !!v || 'Permiso es requerido.',
        ],
    }),
    methods: {
        cerrarEditarAsignacion() {
            this.$emit('cerrarEditarAsignacion')
        },
        guardarAsignacionEditada() {
            console.log(JSON.stringify(this.asignacionEditada, null, 2))
            axios.post('/guardarAsignacionEditada', {

                datos: this.asignacionEditada
            })
                .then(res => {
                    this.loading = false
                    this.$iziToast.success(res)
                    this.cerrarEditarAsignacion()
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
                this.asignacionEditada = this.enviarAsignacion
            })
            .catch(err => {
                this.loading = false
            })
            .finally(() => {
                this.loading = false
            })
    },
    props: {
        enviarAsignacion: {
            id_permiso_rol: Number,
            id_rol: Number,
            nombre_rol: String,
            icono: String,
            id_permiso: Number,
            nombre: String,
            descripcion: String,
            titulo: String,
            path: String,
        }
    }
}
</script>

<style scoped>

</style>
