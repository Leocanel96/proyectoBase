<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialogDesactivarUsuario"
                persistent
                width="800"
            >

                <v-card>

                    <v-card-text>
                        <v-container>
                            <v-alert
                                type="warning"
                                border="start"
                                variant="tonal"
                                color="#01579B"
                                title="Atención"
                            >
                                <ul>
                                    <li><h4>Al realizar esta acción, se desactiva el ingreso al usaurio</h4></li>
                                    <br>
                                    <li><h3 style="text-align: center"><b>¿Está seguro que desea desactivar este usuario?</b></h3></li>
                                </ul>
                            </v-alert>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            prepend-icon="mdi-cancel"
                            color="#DD2C00"
                            class="text-none text-subtitle-1"
                            variant="flat"
                            @click="cancelarDesactivarUsuario"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            prepend-icon="mdi-delete-empty"
                            color="#1565C0"
                            class="text-none text-subtitle-1"
                            variant="flat"
                            @click="desactivarUsuario(enviarDesactivarUsuario)"
                        >
                            Desactivar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </template>
</template>

<script>
export default {
    name: "desactivarUsuario",
    data: () => ({
        dialogDesactivarUsuario: true,
    }),
    methods: {
        cancelarDesactivarUsuario() {
            this.cerrarDesactivarUsuario()
        },
        cerrarDesactivarUsuario() {
            this.$emit('cerrarDesactivarUsuario', null)
        },
        desactivarUsuario(usuario) {
            let usuarioDesactivar = {
                idUsuario: usuario.id_usuario,
            }
            axios.post('/desactivarUsuario', {
                datos: usuarioDesactivar
            })
                .then(res => {
                    this.loading = false
                    this.$iziToast.success(res)
                    this.cerrarDesactivarUsuario()
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
        enviarDesactivarUsuario: {
            id_usuario: Number
        }
    },
}
</script>
<style scoped>

</style>
