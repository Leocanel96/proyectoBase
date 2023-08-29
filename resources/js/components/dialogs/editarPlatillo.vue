<template>
  <template>
    <v-row justify="center">
      <v-dialog
          v-model="dialogEditarPlatillo"
          persistent
          width="800"
      >
        <v-form v-model="validDatos" @submit.prevent="agregarPlatillo">
          <v-card>
            <v-card-title>
              <span class="text-h5 font-weight-black">Editar Platillo {{ platilloEditado.nombre_platillo }}</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                      cols="12"
                      sm="6"

                  >
                    <v-text-field
                        v-model="platilloEditado.nombre_platillo"
                        label="Nombre del platillo"
                        variant="underlined"
                        :rules="nombrePlatilloRule"
                    ></v-text-field>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-text-field
                        v-model="platilloEditado.descripcion_platillo"
                        label="Descripción del platillo"
                        variant="underlined"
                        :rules="descripcionPlatilloRule"
                    ></v-text-field>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-autocomplete
                        :items="items"
                        :custom-filter="buscarPlatillos"
                        item-title="nombre"
                        :loading="loading"
                        :rules="tipoPlatilloRule"
                        v-model="platilloEditado.nombre"
                        variant="underlined"
                        label="Tipo pizza"
                        hide-details
                        hide-selected
                        item-text="nombre"
                        solo
                        return-object
                    ></v-autocomplete>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-text-field
                        v-model="platilloEditado.precio"
                        label="Precio Platillo"
                        variant="underlined"
                        :rules="precioRule"
                        prefix="Q"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-autocomplete
                        :items="promociones"
                        :custom-filter="buscarPromociones"
                        item-title="tipo_promocion"
                        :loading="loading2"
                        :rules="promocionRule"
                        v-model="platilloEditado.tipo_promocion"
                        variant="underlined"
                        label="Promociones"
                        hide-details
                        hide-selected
                        item-text="tipo_promocion"
                        solo
                        return-object
                    ></v-autocomplete>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                  prepend-icon="mdi-cancel"
                  color="#DD2C00"
                  class="text-none text-subtitle-1"
                  variant="flat"
                  @click="cerrarEditarPlatillo"
              >
                Cerrar
              </v-btn>
              <v-btn
                  prepend-icon="mdi-content-save"
                  color="#1565C0"
                  class="text-none text-subtitle-1"
                  variant="flat"
                  :disabled="!validDatos"
                  @click="guardarPlatilloEditado"
              >
                Guardar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-dialog>
    </v-row>
  </template>
</template>
<script>

export default {
  name: "editarPlatillo",
  data: () => ({
    dialogEditarPlatillo: true,
    nombrePlatillo: '',
    descripcionPlatillo: '',
    tipoPlatillo: '',
    precionPlatillo: '',
    promocionPlatillo: '',
    //autocomplete
    loading: false,
    items: [],

    //promociones
    promociones: [],
    loading2: false,

    //formulario
    validDatos: false,
    agregarPlatillo: false,

    platilloEditado: [],

    // Reglas de las cajas de texto
    nombrePlatilloRule: [
      v => !!v || 'Nombre del platillo es requerido',
    ],
    descripcionPlatilloRule: [
      v => !!v || 'Descripciópn del platillo es requerido.',
    ],
    precioRule: [
      v => !!v || 'El precio del platillo es requerido',
      v => v > isNaN(v) || 'El valor debe ser numérico',
    ],
    tipoPlatilloRule: [
      v => !!v || 'Tipo de platillo es requerido.',
    ],
    promocionRule: [
      v => !!v || 'Promoción es requerido.',
    ],
  }),
  methods: {
    cerrarEditarPlatillo() {
      this.$emit('cerrarEditarPlatillo')
    },
    guardarPlatilloEditado() {
      axios.post('/guardarPlatilloEditado', {
        datos: this.platilloEditado
      })
          .then(res => {
            this.loading = false
            this.$iziToast.success("Listo", "Platillo editado correctamente.")
            this.cerrarEditarPlatillo()
          })
          .catch(err => {
            this.$iziToast.success("Atención", "A ocorrido un error al almacenar la información.")
          })
          .finally(() => {
            this.loading = false
          })
    },

    buscarPlatillos(itemTitle, queryText, item) {
      const textOne = item.raw.nombre.toLowerCase()
      const searchText = queryText.toLowerCase()

      return textOne.indexOf(searchText) > -1
    },
    buscarPromociones(itemTitle, queryText, item) {
      const textOne = item.raw.tipo_promocion.toLowerCase()
      const searchText = queryText.toLowerCase()

      return textOne.indexOf(searchText) > -1
    },
  },
  beforeCreate() {
    // Items have already been loaded
    axios.get('/tipoPlatillos', {
      params: {
        nombre: this.search
      }
    })
        .then(res => {
          this.loading = true
          this.items = res.data.respuesta['tipoPlatillos']
          this.promociones = res.data.respuesta['promociones']
          this.platilloEditado = this.enviarPlatillo
        })
        .catch(err => {
          this.loading = false
        })
        .finally(() => {
          this.loading = false
        })
  },
  props: {
    enviarPlatillo: {
      descripcion_platillo: String,
      id_platillo: Number,
      id_promocion: Number,
      id_tipo: Number,
      id_tipo_platillo: Number,
      nombre: String,
      nombre_platillo: String,
      precio: String,
      tipo_promocion: String
    }
  }
}
</script>
<style scoped>

</style>
