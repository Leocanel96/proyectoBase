<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialogEditarRol"
                persistent
                width="700"
            >
                <v-form v-model="validDatos" @submit.prevent="agregarRol">
                    <v-card>
                        <v-card-title>
                            <span class="text-h5 font-weight-black">Editar Rol</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-text-field
                                            v-model="enviarRol.nombre_rol"
                                            label="Nombre del Rol"
                                            variant="underlined"
                                            :rules="nombreRolRule"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-text-field
                                            v-model="enviarRol.icono"
                                            label="Nombre del icono"
                                            placeholder="mdi-pizza"
                                            variant="underlined"
                                            :rules="nombreIconoRule"
                                        ></v-text-field>
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
                                @click="cerrarEditarRol"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                prepend-icon="mdi-content-save"
                                color="#1565C0"
                                class="text-none text-subtitle-1"
                                variant="flat"
                                :disabled="!validDatos"
                                @click="guardarRolEditado"
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
    name: "editarRol",
    data: () => ({
        dialogEditarRol: true,
        nombreRol: '',
        //formulario
        validDatos: false,
        agregarRol: false,


        // Reglas de las cajas de texto
        nombreRolRule: [
            v => !!v || 'Nombre del Rol es requerido',
        ],
        nombreIconoRule: [
            v => !!v || 'Nombre del icono es requerido',
        ]
    }),
    methods: {
        cerrarEditarRol() {
            this.$emit('cerrarEditarRol')
        },
        guardarRolEditado() {

            axios.post('/guardarRolEditado', {
                datos: this.enviarRol
            })
                .then(res => {
                    this.loading = false
                    this.$iziToast.success(res)
                    this.cerrarEditarRol()
                })
                .catch(err => {
                    this.$iziToast.error(err)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    props: {
        enviarRol: {
            nombre_rol: String
        }
    }
}
</script>

<style scoped>

</style>
