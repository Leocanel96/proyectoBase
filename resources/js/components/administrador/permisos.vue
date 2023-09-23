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
                                v-model="buscar"
                                append-icon="mdi-magnify"
                                label="Buscar Permiso"
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
                            @click="agregarPermiso"
                        >
                            Agregar Permiso
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
                        Nombre del permiso
                    </th>
                    <th class="text-left">
                        Descripción
                    </th>
                    <th class="text-left">
                        Fecha de creación
                    </th>
                    <th class="text-left">
                        Acción
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="item in permisos"
                    :key="item.rol"
                >
                    <td>{{ item.nombre_permiso }}</td>
                    <td>{{ item.descripcion }}</td>
                    <td>{{ item.fecha_creacion }}</td>
                    <td class="tamañoIconos">
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="auto"
                                    class="me-auto"
                                    width="15%"
                                >
                                    <div>
                                        <!--                    Editar-->
                                        <v-tooltip
                                            activator="parent"
                                            location="top"
                                        >Editar
                                        </v-tooltip>
                                        <v-icon icon="mdi-pencil"
                                                dark
                                                @click="editarPermiso(item)"
                                        >
                                        </v-icon>

                                        <!--                    Asignar Permisos-->
                                        <v-tooltip
                                            activator="parent"
                                            location="top"
                                        >Asignar Permisos
                                        </v-tooltip>
                                        <v-icon icon="mdi-key-plus"
                                                dark
                                                @click="asignarPermisos(item)"
                                        >
                                        </v-icon>
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
                @update:modelValue="buscarPermisos"
            ></v-pagination>

        </v-card>
        <crear-permiso v-if="agregarNuevoPermiso" @cerrarNuevoPermiso="cerrarNuevoPermiso"></crear-permiso>
        <editar-permiso v-if="verEditarPermiso" :enviarPermiso="enviarPermiso" @cerrarEditarPermiso="cerrarEditarPermiso"></editar-permiso>
        <agregar-permiso v-if="verAgregarPermisos" :enviarAgregarPermiso="enviarAgregarPermiso" @cerrarAgregarPermiso="cerrarAgregarPermiso"></agregar-permiso>
        <!--    <desactivar-rol v-if="verDesactivarRol" :enviarDesactivarRol="enviarDesactivarRol" @cerrarDesactivarRol="cerrarDesactivarRol"></desactivar-rol>-->
    </div>
</template>

<script>
import sha256 from "crypto-js/sha256.js";
import CrearPermiso from "@/components/dialogs/crearPermiso.vue";
import EditarPermiso from "@/components/dialogs/editarPermiso.vue";
import AgregarPermiso from "@/components/dialogs/agregarPermiso.vue";
// import AgregarRol from "@/components/dialogs/agregarRol.vue";

export default {
    name: "permisos",
    components: {AgregarPermiso, EditarPermiso, CrearPermiso},
    data: () => ({
        desserts: [],
        buscar: '',
        agregarNuevoPermiso: false,
        verEditarPermiso: false,
        enviarPermiso: [],
        verAgregarPermisos: false,
        enviarAgregarPermiso: [],
        // verDesactivarRol: false,
        // enviarDesactivarRol: [],
        totalPaginas: 0,
        page: 1
    }),
    methods: {
        agregarPermiso() {
            this.agregarNuevoPermiso = true
        },
        editarPermiso(item) {
            this.verEditarPermiso = true
            this.enviarPermiso = item
        },
        asignarPermisos(item) {
            this.verAgregarPermisos = true
            this.enviarAgregarPermiso = item
        },
        cerrarAgregarPermiso() {
            this.verAgregarPermisos = false
            this.buscarPermisos()
        },
        cerrarNuevoPermiso() {
            this.agregarNuevoPermiso = false
            this.buscarPermisos()
        },
        cerrarEditarPermiso() {
            this.verEditarPermiso = false
            this.buscarPermisos()
        },
        buscarPermisos() {
            axios.get('/obtenerPermisosCreados?page=' + this.page)
                .then(res => {
                    this.desserts = res.data['permisos']['data']
                    this.totalPaginas = res.data.permisos.last_page
                    if (Object.entries(this.desserts).length === 0) {
                        return this.$iziToast.warning("Atención", "No existen Permisos en este momento")
                    }
                })
                .catch(err => {
                    this.$iziToast.error(err)
                })
                .finally(() => {

                })
        }
    },
    computed: {
        permisos: function () {
            return this.desserts.filter((item) => {
                return item.nombre_permiso.toLowerCase().match(this.buscar.toLowerCase());
            })
        }
    },
    beforeCreate() {
        axios.get('/obtenerPermisosCreados?page=' + 1)
            .then(res => {
                this.desserts = res.data['permisos']['data']
                this.totalPaginas = res.data.permisos.last_page
                if (Object.entries(this.desserts).length === 0) {
                    return this.$iziToast.warning("Atención", "No existen permisos en este momento")
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

</style>
