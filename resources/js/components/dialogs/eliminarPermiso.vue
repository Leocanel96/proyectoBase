<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialogEliminarPermiso"
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
                                    <li><h3 style="text-align: center"><b>¿Está seguro que desea eliminar este permiso?</b></h3></li>
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
                            @click="cancelarEliminarPermiso"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            prepend-icon="mdi-delete-empty"
                            color="#1565C0"
                            class="text-none text-subtitle-1"
                            variant="flat"
                            @click="eliminarPermiso(enviarEliminarPermiso)"
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
    name: "eliminarPermiso",
    data: () => ({
        dialogEliminarPermiso: true,
    }),
    methods: {
        cancelarEliminarPermiso() {
            this.cerrarEliminarPermiso()
        },
        cerrarEliminarPermiso() {
            this.$emit('cerrarEliminarPermiso', null)
        },
        eliminarPermiso(permiso) {
            let permisoEliminar = {
                idPermiso: permiso.id_permiso,
            }

            axios.post('/eliminarPermiso', {
                datos: permisoEliminar
            })
                .then(res => {
                    this.loading = false
                    this.$iziToast.success(res)
                    this.cerrarEliminarPermiso()
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
        enviarEliminarPermiso: {
            id_permiso: Number
        }
    },
}
</script>

<style scoped>

</style>
