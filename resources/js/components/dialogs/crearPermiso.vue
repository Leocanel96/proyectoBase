<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialog"
                persistent
                width="600"
            >
                <v-form v-model="validDatos" @submit.prevent="agregarPermiso">
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
                                        <v-text-field
                                            v-model="nombrePermiso"
                                            label="Nombre del Permiso"
                                            variant="underlined"
                                            :rules="nombrePermisoRule"
                                            counter="20"
                                            maxlength="20"
                                        ></v-text-field>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-text-field
                                            v-model="descripcionPermiso"
                                            label="Descripción permiso"
                                            variant="underlined"
                                            :rules="descripcionPermisoRule"
                                            counter="100"
                                            maxlength="100"
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
                                @click="cerrarAgregarPermiso"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                prepend-icon="mdi-content-save"
                                color="#1565C0"
                                class="text-none text-subtitle-1"
                                variant="flat"
                                @click="guardarPermiso"
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
    name: "crearPermiso",
    data: () => ({
        dialog: true,
        nombrePermiso: '',
        descripcionPermiso: '',
        //formulario
        validDatos: false,
        agregarPermiso: false,

        // Reglas de las cajas de texto
        nombrePermisoRule: [
            v => !!v || 'Nombre del permiso es requerido',
        ],
        descripcionPermisoRule: [
            v => !!v || 'Descripción del permiso es requerido',
        ]
    }),
    methods: {
        cerrarAgregarPermiso() {
            this.$emit('cerrarNuevoPermiso', null)
        },
        guardarPermiso() {
            let permiso = {
                nombrePermiso: this.nombrePermiso,
                descripcionPermiso: this.descripcionPermiso
            }

            axios.post('/guardarPermiso', {
                datos: permiso
            })
                .then(res => {
                    this.loading = false
                    this.$iziToast.success(res)
                    this.limpiarCampos()
                    this.cerrarAgregarPermiso()
                })
                .catch(err => {
                    this.$iziToast.error(err)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        limpiarCampos() {
            this.nombrePermiso = ''
        }
    }
}
</script>


<style scoped>

</style>
