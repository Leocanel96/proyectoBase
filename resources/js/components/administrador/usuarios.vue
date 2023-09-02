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
    <agregar-usuario v-if="agregarNuevoUsuario" @cerrarNuevoUsuario="cerrarNuevoUsuario"></agregar-usuario>
    <!--    <agregar-platillos v-if="agregarNuevoPlatillo" @cerrarNuevoPlatillo="cerrarNuevoPlatillo"></agregar-platillos>
        <editar-platillo v-if="verEditarPlatillo" :enviarPlatillo="enviarPlatillo" @cerrarEditarPlatillo="cerrarEditarPlatillo"></editar-platillo>
        <eliminar-platillo v-if="verEliminarPlatillo" :enviarEliminarPlatillo="enviarEliminarPlatillo" @cerrarEliminarPlatillo="cerrarEliminarPlatillo"></eliminar-platillo>-->
  </div>
</template>

<script>
// import AgregarPlatillos from "@/components/dialogs/agregarPlatillos.vue";

import AgregarUsuario from "@/components/dialogs/agregarUsuario.vue";

export default {
  name: "usuarios",
  components: {AgregarUsuario},
  // AgregarPlatillos,
  data: () => ({
    desserts: [],
    buscar: '',
    agregarNuevoUsuario: false,

    // verEditarPlatillo: false,
    // enviarPlatillo: [],
    //
    // verEliminarPlatillo: false,
    // enviarEliminarPlatillo: []
  }),
  methods: {
    agregarUsuario() {
      console.log("ingresa en el boton")
      // this.agregarNuevoPlatillo = true
      this.agregarNuevoUsuario = true
    },
    editarUsuario(item) {
      console.log(JSON.stringify(item, null, 2))
      // this.verEditarPlatillo = true
      // this.enviarPlatillo = item
    },
    eliminarUsuario(item) {
      console.log(JSON.stringify(item, null, 2))
      // this.verEliminarPlatillo = true
      // this.enviarEliminarPlatillo = item
    },

    cerrarNuevoUsuario() {
      this.agregarNuevoUsuario = false
      this.buscarUsuarios()
    },
    buscarUsuarios() {
      axios.get('/obtenerUsuariosCreados')
          .then(res => {
            this.desserts = res.data.usuarios
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
    axios.get('/obtenerUsuariosCreados')
        .then(res => {
          this.desserts = res.data.usuarios
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
