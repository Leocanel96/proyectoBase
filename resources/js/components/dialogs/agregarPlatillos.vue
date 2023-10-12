<template>
  <template>
    <v-row justify="center">
      <v-dialog
          v-model="dialog"
          persistent
          width="800"
      >
        <v-form v-model="validDatos" @submit.prevent="agregarPlatillo" enctype="multipart/form-data">
          <v-card>
            <v-card-title>
              <span class="text-h5">Agregar platillo</span>
            </v-card-title>
            <v-card-text>

              <v-container>
                <v-row>
                  <v-col
                      cols="12"
                      sm="6"

                  >
                    <v-text-field
                        v-model="formData.nombrePlatillo"
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
                        v-model="formData.descripcionPlatillo"
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
                        v-model="tipoPlatillo"
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
                        v-model="formData.precionPlatillo"
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
                        v-model="promocionPlatillo"
                        variant="underlined"
                        label="Promociones"
                        hide-details
                        hide-selected
                        item-text="tipo_promocion"
                        solo
                        return-object
                    ></v-autocomplete>
                  </v-col>
                  <v-col>
                    <v-file-input
                        ref="imagenCargar"
                        v-model="imagenPlatillo"
                        :rules="imagenPlatilloRule"
                        accept="image/png, image/jpeg, image/bmp"
                        prepend-icon="mdi-camera"
                        label="Imagen platillo"
                        @change="handleFileUpload"
                    ></v-file-input>
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
                  @click="cerrarAgregarPlatillos"
              >
                Cerrar
              </v-btn>
              <v-btn
                  prepend-icon="mdi-content-save"
                  color="#1565C0"
                  class="text-none text-subtitle-1"
                  variant="flat"
                  @click="guardarPlatillo"
                  :disabled="!validDatos"
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

  name: "agregarPlatillos",
  data: () => ({
    dialog: true,
    formData: {
      nombrePlatillo: '',
      descripcionPlatillo: '',
      precionPlatillo: '',

    },
    promocionPlatillo: '',
    tipoPlatillo: '',
    imagenPlatillo: null,
    //autocomplete
    loading: false,
    items: [],

    //promociones
    promociones: [],
    loading2: false,

    //formulario
    validDatos: false,
    agregarPlatillo: false,

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
    imagenPlatilloRule: [
      v => {
        return !v || !v.length || v[0].size < 2000000 || 'El tamaño de la imagen debe ser inferior a 2MB!'
      },
      v => !!v || 'Imagen es requerida',
    ]
  }),
  methods: {
    cerrarAgregarPlatillos() {
      this.$emit('cerrarNuevoPlatillo', null)
    },
    handleFileUpload(event) {
      this.imagen = event.target.files[0];
    },
    guardarPlatillo() {
      console.log(JSON.stringify(this.promocionPlatillo, null, 2))
      const formData = new FormData();
      formData.append('nombrePlatillo', this.formData.nombrePlatillo)
      formData.append('descripcionPlatillo', this.formData.descripcionPlatillo)
      formData.append('idTipoPlatillo', this.tipoPlatillo['id_tipo'])
      formData.append('nombreTipoPlatillo', this.tipoPlatillo['nombre'])
      formData.append('precioPlatillo', this.formData.precionPlatillo)
      formData.append('idPromocionPlatillo', this.promocionPlatillo['id_promocion'])
      formData.append('tipoPromocionPlatillo', this.promocionPlatillo['tipo_promocion'])
      formData.append('montoPromocionPlatillo', this.promocionPlatillo['monto_promocion'])


      formData.append('imagen', this.imagen)

      axios.post('/guardarPlatillo', formData)
          .then(res => {
            this.loading = false
            this.$iziToast.success(res)
            this.limpiarCampos()
            this.cerrarAgregarPlatillos()
          })
          .catch(err => {
            this.loading = false
            this.$iziToast.success(res)
            this.limpiarCampos()
            this.cerrarAgregarPlatillos()
          });

      // const img = this.$refs.imagen.files[0]
      // let platillo = {
      //   nombrePlatillo: this.nombrePlatillo,
      //   descripcionPlatillo: this.descripcionPlatillo,
      //   tipoPlatillo: this.tipoPlatillo,
      //   precioPlatillo: this.precionPlatillo,
      //   promocion: this.promocionPlatillo,
      //   imagen: this.imagenPlatillo
      //
      // }
      //
      // axios.post('/guardarPlatillo', {
      //   nombrePlatillo: this.nombrePlatillo,
      //   descripcionPlatillo: this.descripcionPlatillo,
      //   tipoPlatillo: this.tipoPlatillo,
      //   precioPlatillo: this.precionPlatillo,
      //   promocion: this.promocionPlatillo,
      //   imagen: this.imagenPlatillo,
      //   headers: {
      //     'Content-Type': 'multipart/form-data',
      //   },
      // })
      //     .then(res => {
      //       this.loading = false
      //       this.$iziToast.success(res)
      //       this.limpiarCampos()
      //       this.cerrarAgregarPlatillos()
      //     })
      //     .catch(err => {
      //       this.$iziToast.error(err)
      //     })
      //     .finally(() => {
      //       this.loading = false
      //     })
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
    limpiarCampos() {
      this.nombrePlatillo = ''
      this.descripcionPlatillo = ''
      this.tipoPlatillo = ''
      this.precionPlatillo = ''
      this.promocionPlatillo = ''
    }

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
        })
        .catch(err => {
          this.loading = false
        })
        .finally(() => {
          this.loading = false
        })
  }
}
</script>

<style scoped>

</style>
