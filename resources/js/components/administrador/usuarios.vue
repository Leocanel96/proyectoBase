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
                  label="Buscar Platillo"
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
        >
          <td>{{ item.nombres }}</td>
          <td>{{ item.apellidos }}</td>
          <td>{{ item.correo }}</td>
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
                    >Eliminar
                    </v-tooltip>
                    <v-icon icon="mdi-delete"
                            dark
                            @click="eliminarUsuario(item)"
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

    </v-card>

    <!--    <agregar-platillos v-if="agregarNuevoPlatillo" @cerrarNuevoPlatillo="cerrarNuevoPlatillo"></agregar-platillos>
        <editar-platillo v-if="verEditarPlatillo" :enviarPlatillo="enviarPlatillo" @cerrarEditarPlatillo="cerrarEditarPlatillo"></editar-platillo>
        <eliminar-platillo v-if="verEliminarPlatillo" :enviarEliminarPlatillo="enviarEliminarPlatillo" @cerrarEliminarPlatillo="cerrarEliminarPlatillo"></eliminar-platillo>-->
  </div>
</template>

<script>
// import AgregarPlatillos from "@/components/dialogs/agregarPlatillos.vue";

export default {
  name: "usuarios",
  components: {},
  // AgregarPlatillos,
  data: () => ({
    desserts: [],
    buscar: '',
    agregarNuevoPlatillo: false,

    verEditarPlatillo: false,
    enviarPlatillo: [],

    verEliminarPlatillo: false,
    enviarEliminarPlatillo: []
  }),
  methods: {
    agregarUsuario() {
      // this.agregarNuevoPlatillo = true
    },
    editarUsuario(item) {
      console.log(item)
      // this.verEditarPlatillo = true
      // this.enviarPlatillo = item
    },
    eliminarUsuario(item) {
      console.log(item)
      // this.verEliminarPlatillo = true
      // this.enviarEliminarPlatillo = item
    },
    /*
    cerrarNuevoPlatillo() {
      this.agregarNuevoPlatillo = false
      this.buscarPlatillos()
    },
    cerrarEditarPlatillo() {
      this.verEditarPlatillo = false
      this.buscarPlatillos()
    },
    cerrarEliminarPlatillo() {
      this.verEliminarPlatillo = false
      this.buscarPlatillos()
    },
    buscarPlatillos() {
      axios.get('/obtenerPlatillosCreados')
          .then(res => {
            this.desserts = res.data.platillos
          })
          .catch(err => {
          })
          .finally(() => {
          })
    }*/
  },
  beforeCreate() {
    axios.get('/obtenerUsuariosCreados')
        .then(res => {
          this.desserts = res.data.usuarios
          console.log(JSON.stringify(this.desserts, null, 2))
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
