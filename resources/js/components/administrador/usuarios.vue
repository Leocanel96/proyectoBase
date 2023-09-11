<template>
    <div>
        <v-card
            elevation="12"
            class="mx-auto my-12"
            max-width="1200"
        >
            <v-container>
                <v-row>
                    <v-col
                        cols="12"
                        sm="8"
                    >
                        <v-card-title>
                            <v-text-field
                                append-icon="mdi-magnify"
                                label="Buscar Usuario"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                    </v-col>
                    <v-col
                        cols="12"
                        sm="4"
                    >
                        <v-btn
                            color="info"
                            dark
                            @click="agregarUsuario"
                        >
                            Agregar usuario
                            <v-icon
                                end
                                icon="mdi-plus"
                            ></v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>

            <v-table>
                <thead>
                <tr>
                    <th class="text-left">
                        Nombres
                    </th>
                    <th class="text-left">
                        Apellidos
                    </th>
                    <th class="text-left">
                        Correo
                    </th>
                    <th class="text-left">
                        Estado
                    </th>
                    <th class="text-left">
                        Rol
                    </th>
                    <th class="text-left">
                        Acción
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="item in desserts"
                    :key="item.name"
                >
                    <td>{{ item.nombres }}</td>
                    <td>{{ item.apellidos }}</td>
                    <td>{{ item.correo }}</td>
                    <td>{{ item.estado_usuario }}</td>
                    <td>{{ item.nombre_rol }}</td>
                    <td class="tamañoIconos">
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="auto"
                                    class="me-auto"
                                >
                                    <div>
                                        <v-tooltip
                                            activator="parent"
                                            location="top"
                                        >Editar
                                        </v-tooltip>
                                        <v-icon icon="mdi-pencil"
                                                dark
                                                @click="editarUsuario(item)"
                                        >
                                        </v-icon>
                                    </div>
                                </v-col>
                                <v-col
                                    cols="auto"
                                    class="me-auto"
                                >
                                    <div>
                                        <v-tooltip
                                            activator="parent"
                                            location="top"
                                        >Desactivar usuario
                                        </v-tooltip>
                                        <div v-if="item.id_estado_usuario==1">
                                            <v-icon icon="mdi-account-off"
                                                    dark
                                                    @click="desactivarUsuario(item)"
                                            >
                                            </v-icon>
                                        </div>
                                        <div v-else>
                                            <v-tooltip
                                                activator="parent"
                                                location="top"
                                            >Activar usuario
                                            </v-tooltip>
                                            <v-icon icon="mdi-check-all"
                                                    dark
                                                    @click="activarUsuario(item)"
                                            >
                                            </v-icon>
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-container>
                    </td>
                </tr>
                </tbody>
            </v-table>
            <v-pagination
                v-model="page"
                :length="totalPaginas"
                :total-visible="10"
                rounded="circle"
                @update:modelValue="buscarUsuarios"
            ></v-pagination>

        </v-card>
        <agregar-usuario v-if="agregarNuevoUsuario" @cerrarNuevoUsuario="cerrarNuevoUsuario"></agregar-usuario>
        <editar-usuario v-if="verEditarUsuario" :enviarUsuario="enviarUsuario" @cerrarUsuarioEditado="cerrarUsuarioEditado"></editar-usuario>
        <desactivar-usuario v-if="verDesactivarUsuario" :enviarDesactivarUsuario="enviarDesactivarUsuario" @cerrarDesactivarUsuario="cerrarDesactivarUsuario"></desactivar-usuario>
    </div>
</template>

<script>

import AgregarUsuario from "@/components/dialogs/agregarUsuario.vue";
import EditarUsuario from "@/components/dialogs/editarUsuario.vue";
import DesactivarUsuario from "@/components/dialogs/desactivarUsuario.vue";

export default {
    name: "usuarios",
    components: {DesactivarUsuario, EditarUsuario, AgregarUsuario},
    // AgregarPlatillos,
    data: () => ({
        desserts: [],
        buscar: '',
        agregarNuevoUsuario: false,
        verEditarUsuario: false,
        enviarUsuario: [],
        verDesactivarUsuario: false,
        enviarDesactivarUsuario: [],
        totalPaginas: 0,
        page: 1
    }),
    methods: {
        agregarUsuario() {
            this.agregarNuevoUsuario = true
        },
        editarUsuario(item) {
            this.verEditarUsuario = true
            this.enviarUsuario = item
        },
        desactivarUsuario(item) {
            this.verDesactivarUsuario = true
            this.enviarDesactivarUsuario = item
        },
        activarUsuario(item) {
            axios.post('/activarUsuario', {
                datos: item
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
        },
        cerrarNuevoUsuario() {
            this.agregarNuevoUsuario = false
            this.buscarUsuarios()
        },
        cerrarUsuarioEditado() {
            this.verEditarUsuario = false
            this.buscarUsuarios()
        },
        cerrarDesactivarUsuario() {
            this.verDesactivarUsuario = false
            this.buscarUsuarios()
        },
        buscarUsuarios() {
            axios.get('/obtenerUsuariosCreados?page=' + this.page)
                .then(res => {
                    this.desserts = res.data['usuarios']['data']
                    this.totalPaginas = res.data.usuarios.last_page
                    if (Object.entries(this.desserts).length === 0) {
                        return this.$iziToast.warning("Atención", "No existen usuarios en este momento")
                    }
                })
                .catch(err => {
                    this.$iziToast.error(err)
                })
                .finally(() => {

                })
        }
    },
    beforeCreate() {
        axios.get('/obtenerUsuariosCreados?page=' + 1)
            .then(res => {
                this.desserts = res.data['usuarios']['data']
                this.totalPaginas = res.data.usuarios.last_page
                if (Object.entries(this.desserts).length === 0) {
                    return this.$iziToast.warning("Atención", "No existen usuarios en este momento")
                }
            })
            .catch(err => {
                this.$iziToast.error(err)
            })
            .finally(() => {

            })
    },

}
</script>

<style scoped>
.tamañoIconos {
    width: 15%;
}
</style>
