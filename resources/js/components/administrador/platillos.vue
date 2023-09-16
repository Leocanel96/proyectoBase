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

            <!--            <v-btn-->
            <!--                color="info"-->
            <!--                dark-->
            <!--                @click="enviarCorreo"-->
            <!--            >-->
            <!--              Enviar correo-->
            <!--              <v-icon-->
            <!--                  end-->
            <!--                  icon="mdi-plus"-->
            <!--              ></v-icon>-->
            <!--            </v-btn>-->
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
            v-for="item in platillos"
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
      <v-pagination
          v-model="page"
          :length="totalPaginas"
          :total-visible="10"
          rounded="circle"
          @update:modelValue="buscarPlatillos"
      ></v-pagination>


    </v-card>

    <agregar-platillos v-if="agregarNuevoPlatillo" @cerrarNuevoPlatillo="cerrarNuevoPlatillo"></agregar-platillos>
    <editar-platillo v-if="verEditarPlatillo" :enviarPlatillo="enviarPlatillo" @cerrarEditarPlatillo="cerrarEditarPlatillo"></editar-platillo>
    <eliminar-platillo v-if="verEliminarPlatillo" :enviarEliminarPlatillo="enviarEliminarPlatillo" @cerrarEliminarPlatillo="cerrarEliminarPlatillo"></eliminar-platillo>
  </div>
</template>

<script>

import AgregarPlatillos from "../dialogs/agregarPlatillos.vue";
import EditarPlatillo from "@/components/dialogs/editarPlatillo.vue";
import EliminarPlatillo from "@/components/dialogs/eliminarPlatillo.vue";

export default {
  name: "platillos",
  components: {EliminarPlatillo, EditarPlatillo, AgregarPlatillos},
  data: () => ({
    desserts: [],
    buscar: '',
    agregarNuevoPlatillo: false,

    verEditarPlatillo: false,
    enviarPlatillo: [],

    verEliminarPlatillo: false,
    enviarEliminarPlatillo: [],

    totalPaginas: 0,
    page: 1,

    contenidoTabla: []
  }),
  methods: {
    agregarPlatillo() {
      this.agregarNuevoPlatillo = true
    },
    editarPlatillo(item) {
      this.verEditarPlatillo = true
      this.enviarPlatillo = item
    },
    eliminarPlatillo(item) {
      this.verEliminarPlatillo = true
      this.enviarEliminarPlatillo = item
    },
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
      axios.get('/obtenerPlatillosCreados?page=' + this.page)
          .then(res => {
            this.desserts = res.data['platillos']['data']
            this.totalPaginas = res.data['platillos'].last_page
          })
          .catch(err => {
          })
          .finally(() => {
          })
    },
    /*    enviarCorreo() {
          let correos = {
            mensaje: "hola",
            corre: "henry-cotzajay@hotmail.com"
          }
          axios.post('/enviarCorreo', {
            datos: correos
          })
              .then(res => {
                this.loading = false
                this.$iziToast.success(res)
                this.limpiarCampos()
                this.cerrarAgregarPlatillos()
              })
              .catch(err => {
                this.$iziToast.error(err)
              })
              .finally(() => {
                this.loading = false
              })
        }*/
  },
  computed: {
    platillos: function () {
      return this.desserts.filter((item) => {
        return item.nombre_platillo.toLowerCase().match(this.buscar.toLowerCase());
      })
    }
  },
  beforeCreate() {
    axios.get('/obtenerPlatillosCreados?page=' + 1)
        .then(res => {
          this.desserts = res.data['platillos']['data']
          this.totalPaginas = res.data['platillos'].last_page
          if (Object.entries(this.desserts).length === 0) {
            return this.$iziToast.warning("Atención", "No existen platillos en este momento")
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
