<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialog"
                persistent
                width="600"
            >
                <v-form v-model="validDatos" @submit.prevent="agregarRol">
                    <v-card>
                        <v-card-title>
                            <span class="text-h5">Agregar Rol</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                    >
                                        <v-text-field
                                            v-model="nombreRol"
                                            label="Nombre del Rol"
                                            variant="underlined"
                                            :rules="nombreRolRule"
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
                                @click="cerrarAgregarRol"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                prepend-icon="mdi-content-save"
                                color="#1565C0"
                                class="text-none text-subtitle-1"
                                variant="flat"
                                @click="guardarRol"
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
    name: "agregarRol",
    data: () => ({
        dialog: true,
        nombreRol: '',
        //formulario
        validDatos: false,
        agregarRol: false,

        // Reglas de las cajas de texto
        nombreRolRule: [
            v => !!v || 'Nombre del rol es requerido',
        ]
    }),
    methods: {
        cerrarAgregarRol() {
            this.$emit('cerrarNuevoRol', null)
        },
        guardarRol() {
            let rol = {
                nombreRol: this.nombreRol,
            }

            axios.post('/guardarRol', {
                datos: rol
            })
                .then(res => {
                    this.loading = false
                    this.$iziToast.success(res)
                    this.limpiarCampos()
                    this.cerrarAgregarRol()
                })
                .catch(err => {
                    this.$iziToast.error(err)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        limpiarCampos() {
            this.nombreRol = ''
        }
    }
}
</script>

<style scoped>

</style>
