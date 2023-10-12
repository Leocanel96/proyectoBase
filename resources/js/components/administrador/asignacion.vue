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
                            @click="asignarPermisoRol"
                        >
                            Agregar Permiso Rol
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
                        Nombre del Rol
                    </th>
                    <th class="text-left">
                        Nombre del permiso
                    </th>
                    <th class="text-left">
                        Descripción
                    </th>
                    <th class="text-left">
                        Ruta (Path)
                    </th>
                    <th class="text-left">
                        Icono
                    </th>
                    <th class="text-left">
                        Nombre del icono
                    </th>
                    <th class="text-left">
                        Acción
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="item in desserts"
                    :key="item.id_permiso"
                >
                    <td>{{ item.nombre_rol }}</td>
                    <td>{{ item.nombre }}</td>
                    <td>{{ item.descripcion }}</td>
                    <td>{{ item.path }}</td>
                    <td>
                        <v-icon>
                            {{ item.icono }}
                        </v-icon>
                    </td>
                    <td>{{ item.icono }}</td>
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
                                                @click="editarAsignacion(item)"
                                        >
                                        </v-icon>
                                    </div>
                                    <div>
                                        <v-tooltip
                                            activator="parent"
                                            location="top"
                                        >Eliminar
                                        </v-tooltip>
                                        <v-icon icon="mdi-delete-empty"
                                                dark
                                                @click="eliminarAsignacion(item)"
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
                @update:modelValue="buscarPermisosAsignados"
            ></v-pagination>

        </v-card>
        <crear-asignacion-permiso-rol v-if="agregarNuevaAsignacionPermisoRol" @cerrarNuevaAsignacion="cerrarNuevaAsignacion"></crear-asignacion-permiso-rol>
        <editar-asignacion v-if="verEditarAsignacion" :enviarAsignacion="enviarAsignacion" @cerrarEditarAsignacion="cerrarEditarAsignacion"></editar-asignacion>
        <eliminar-asignacion v-if="verEliminarAsignacion" :enviarEliminarAsignacion="enviarEliminarAsignacion" @cerrarEliminarAsignacion="cerrarEliminarAsignacion"></eliminar-asignacion>
    </div>
</template>

<script>
import CrearAsignacionPermisoRol from "@/components/dialogs/crearAsignacionPermisoRol.vue";
import EditarAsignacion from "@/components/dialogs/editarAsignacion.vue";
import EliminarAsignacion from "@/components/dialogs/eliminarAsignacion.vue";

export default {
    name: "asignacion",
    components: {EliminarAsignacion, EditarAsignacion, CrearAsignacionPermisoRol},
    data: () => ({
        desserts: [],
        buscar: '',
        agregarNuevaAsignacionPermisoRol: false,
        verEditarAsignacion: false,
        enviarAsignacion: [],

        verEliminarAsignacion: false,
        enviarEliminarAsignacion: [],


        totalPaginas: 0,
        page: 1
    }),
    methods: {
        asignarPermisoRol() {
            this.agregarNuevaAsignacionPermisoRol = true
        },
        editarAsignacion(item) {
            this.verEditarAsignacion = true
            this.enviarAsignacion = item

        },
        cerrarNuevaAsignacion() {
            this.agregarNuevaAsignacionPermisoRol = false
            this.buscarPermisosAsignados()
        },
        cerrarEditarAsignacion() {
            this.verEditarAsignacion = false
            this.buscarPermisosAsignados()
        },
        eliminarAsignacion(item) {
            this.verEliminarAsignacion = true
            this.enviarEliminarAsignacion = item
        },
        cerrarEliminarAsignacion() {
            this.verEliminarAsignacion = false
            this.buscarPermisosAsignados()
        },

        buscarPermisosAsignados() {
            axios.get('/obtenerPermisosAsignados?page=' + this.page)
                .then(res => {
                    this.desserts = res.data['permisosAsignacion']['data']
                    this.totalPaginas = res.data.permisosAsignacion.last_page
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
        axios.get('/obtenerPermisosAsignados?page=' + 1)
            .then(res => {
                this.desserts = res.data['permisosAsignacion']['data']
                this.totalPaginas = res.data.permisosAsignacion.last_page
                if (Object.entries(this.desserts).length === 0) {
                    return this.$iziToast.warning("Atención", "No existen permisos en este momento")
                }
            })
            .catch(err => {
                this.$iziToast.error(err)
            })
            .finally(() => {

            })
    }
}
</script>
<style scoped>

</style>
