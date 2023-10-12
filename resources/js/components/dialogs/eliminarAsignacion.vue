<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialogEliminarAsignacion"
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
                                    <li><h4>Al realizar esta acción, no se podrá revertir.</h4></li>
                                    <br>
                                    <li><h3 style="text-align: center"><b>¿Está seguro que desea eliminar esta asignación?</b></h3></li>
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
                            @click="cancelarEliminarAsignacion"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            prepend-icon="mdi-delete-empty"
                            color="#1565C0"
                            class="text-none text-subtitle-1"
                            variant="flat"
                            @click="eliminarAsignacion(enviarEliminarAsignacion)"
                        >
                            Aceptar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </template>
</template>

<script>
export default {
    name: "eliminarAsignacion",
    data: () => ({
        dialogEliminarAsignacion: true,
    }),
    methods: {
        cancelarEliminarAsignacion() {
            this.cerrarEliminarAsignacion()
        },
        cerrarEliminarAsignacion() {
            this.$emit('cerrarEliminarAsignacion', null)
        },
        eliminarAsignacion(asignacion) {
            let asignacionEliminar = {
                idAsignacion: asignacion.id_permiso_rol,
            }

            axios.post('/eliminarAsignacion', {
                datos: asignacionEliminar
            })
                .then(res => {
                    this.loading = false
                    this.$iziToast.success(res)
                    this.cerrarEliminarAsignacion()
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
        enviarEliminarAsignacion: {
            id_permiso_rol: Number
        }
    },
}
</script>


<style scoped>

</style>
