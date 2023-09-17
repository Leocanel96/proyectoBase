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
                  label="Buscar rol"
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
                @click="agregarRol"
            >
              Agregar Rol
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
            Rol
          </th>
          <th class="text-left">
            Estado Rol
          </th>
          <th class="text-left">
            Acción
          </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in roles"
            :key="item.rol"
        >
          <td>{{ item.nombre_rol }}</td>
          <td>{{ item.estado_rol }}</td>
          <td class="tamañoIconos">
            <v-container>
              <v-row>
                <v-col
                    cols="auto"
                    class="me-auto"
                    width="10%"
                >
                  <div>
                    <v-tooltip
                        activator="parent"
                        location="top"
                    >Editar
                    </v-tooltip>
                    <v-icon icon="mdi-pencil"
                            dark
                            @click="editarRol(item)"
                    >
                    </v-icon>
                  </div>
                  <div style="margin: 3%">
                    <v-tooltip
                        activator="parent"
                        location="top"
                    >Desactivar Rol
                    </v-tooltip>
                    <div v-if="item.id_estado_rol==1">
                      <v-icon icon="mdi-account-off"
                              dark
                              @click="desactivarRol(item)"
                      >
                      </v-icon>
                    </div>
                    <div v-else>
                      <v-tooltip
                          activator="parent"
                          location="top"
                      >Activar Rol
                      </v-tooltip>
                      <v-icon icon="mdi-check-all"
                              dark
                              @click="activarRol(item)"
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
          @update:modelValue="buscarRoles"
      ></v-pagination>

    </v-card>
    <agregar-rol v-if="agregarNuevoRol" @cerrarNuevoRol="cerrarNuevoRol"></agregar-rol>
    <editar-rol v-if="verEditarRol" :enviarRol="enviarRol" @cerrarEditarRol="cerrarEditarRol"></editar-rol>
    <desactivar-rol v-if="verDesactivarRol" :enviarDesactivarRol="enviarDesactivarRol" @cerrarDesactivarRol="cerrarDesactivarRol"></desactivar-rol>
  </div>
</template>

<script>
import AgregarRol from "../dialogs/agregarRol.vue";
import EditarRol from "@/components/dialogs/editarRol.vue";
import DesactivarRol from "@/components/dialogs/desactivarRol.vue";

export default {
  name: "roles",
  components: {DesactivarRol, EditarRol, AgregarRol},
  data: () => ({
    desserts: [],
    buscar: '',
    agregarNuevoRol: false,
    verEditarRol: false,
    enviarRol: [],
    verDesactivarRol: false,
    enviarDesactivarRol: [],
    totalPaginas: 0,
    page: 1
  }),
  methods: {
    agregarRol() {
      this.agregarNuevoRol = true
    },
    editarRol(item) {
      this.verEditarRol = true
      this.enviarRol = item
    },
    desactivarRol(item) {
      this.verDesactivarRol = true
      this.enviarDesactivarRol = item
    },
    activarRol(item) {
      axios.post('/activarRol', {
        datos: item
      })
          .then(res => {
            this.loading = false
            this.$iziToast.success(res)
            this.cerrarDesactivarRol()
          })
          .catch(err => {
            this.$iziToast.error(err)
          })
          .finally(() => {
            this.loading = false
          })
    },
    cerrarNuevoRol() {
      this.agregarNuevoRol = false
      this.buscarRoles()
    },
    cerrarEditarRol() {
      this.verEditarRol = false
      this.buscarRoles()
    },
    cerrarDesactivarRol() {
      this.verDesactivarRol = false
      this.buscarRoles()
    },
    buscarRoles() {
      axios.get('/obtenerRolesCreados?page=' + this.page)
          .then(res => {
            this.desserts = res.data['roles']['data']
            this.totalPaginas = res.data.roles.last_page
            if (Object.entries(this.desserts).length === 0) {
              return this.$iziToast.warning("Atención", "No existen roles en este momento")
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
    roles: function () {
      return this.desserts.filter((item) => {
        return item.nombre_rol.toLowerCase().match(this.buscar.toLowerCase());
      })
    }
  },
  beforeCreate() {
    axios.get('/obtenerRolesCreados?page=' + 1)
        .then(res => {
          this.desserts = res.data['roles']['data']
          this.totalPaginas = res.data.roles.last_page
          if (Object.entries(this.desserts).length === 0) {
            return this.$iziToast.warning("Atención", "No existen roles en este momento")
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
