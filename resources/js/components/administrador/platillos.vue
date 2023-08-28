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
                @click="agregarPlatillo"
            >
              Agregar platillo
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
            Nombre del platillo
          </th>
          <th class="text-left">
            Descripción
          </th>
          <th class="text-left">
            Precio
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
          <td>{{ item.nombre_platillo }}</td>
          <td>{{ item.descripcion_platillo }}</td>
          <td>{{ item.precio }}</td>
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
                            @click="editarPlatillo(item)"
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
                    >Elimitar
                    </v-tooltip>
                    <v-icon icon="mdi-delete"
                            dark
                            @click="eliminarPlatillo(item)"
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

    <agregar-platillos v-if="agregarNuevoPlatillo" @cerrarNuevoPlatillo="cerrarNuevoPlatillo"></agregar-platillos>
    <editar-platillo v-if="verEditarPlatillo" :enviarPlatillo="enviarPlatillo" @cerrarEditarPlatillo="cerrarEditarPlatillo"></editar-platillo>
  </div>
</template>

<script>

import AgregarPlatillos from "../dialogs/agregarPlatillos.vue";
import EditarPlatillo from "@/components/dialogs/editarPlatillo.vue";

export default {
  name: "platillos",
  components: {EditarPlatillo, AgregarPlatillos},
  data: () => ({
    desserts: [],
    buscar: '',
    agregarNuevoPlatillo: false,
    verEditarPlatillo: false,
    enviarPlatillo: [],
  }),
  methods: {
    agregarPlatillo() {
      this.agregarNuevoPlatillo = true
    },
    editarPlatillo(item) {
      this.verEditarPlatillo = true
      this.enviarPlatillo = item
    },
    eliminarPlatillo() {

    },
    cerrarNuevoPlatillo() {
      this.agregarNuevoPlatillo = false
      this.buscarPlatillos()
    },
    cerrarEditarPlatillo() {
      this.verEditarPlatillo = false
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
    }
  },
  beforeCreate() {
    axios.get('/obtenerPlatillosCreados')
        .then(res => {
          this.desserts = res.data.platillos
          if (Object.entries(this.desserts).length === 0) {
            return this.$iziToast.warning("Atención", "No existen platillos en este momento")
          }
        })
        .catch(err => {
          this.$iziToast.error("Atención", "Ha ocurrido un error al obtener la información")
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
