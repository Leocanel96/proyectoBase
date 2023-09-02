<template>
  <template>
    <v-row justify="center">
      <v-dialog
          v-model="dialog"
          persistent
          width="800"
      >
        <v-form v-model="validDatos" @submit.prevent="agregarUsuario">
          <v-card>
            <v-card-title>
              <span class="text-h5">Agregar Usuario</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-text-field
                        v-model="nombres"
                        label="Nombres"
                        variant="underlined"
                        :rules="nombresRule"
                    ></v-text-field>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-text-field
                        v-model="apellidos"
                        label="Descripción del platillo"
                        variant="underlined"
                        :rules="apellidosRule"
                    ></v-text-field>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-text-field
                        v-model="correo"
                        label="Descripción del platillo"
                        variant="underlined"
                        :rules="correoRule"
                    ></v-text-field>
                  </v-col>
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
                  @click="cerrarAgregarUsuario"
              >
                Cerrar
              </v-btn>
              <v-btn
                  prepend-icon="mdi-content-save"
                  color="#1565C0"
                  class="text-none text-subtitle-1"
                  variant="flat"
                  @click="guardarUsuario"
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
  name: "agregarUsuario",
  data: () => ({
    dialog: true,
    nombres: '',
    apellidos: '',
    correo: '',
    rol: '',
    promocionPlatillo: '',
    //autocomplete
    loading: false,
    items: [],

    //promociones
    promociones: [],
    loading2: false,

    //formulario
    validDatos: false,
    agregarUsuario: false,

    // Reglas de las cajas de texto
    nombresRule: [
      v => !!v || 'Los nombres son requeridos',
    ],
    apellidosRule: [
      v => !!v || 'Los apellidos son requeridos.',
    ],
    correoRule: [
      v => !!v || 'Correo es requerido.',
      v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Correo debe ser valido.'
    ],
    rolRule: [
      v => !!v || 'Rol es requerido.',
    ],
  }),
  methods: {
    cerrarAgregarUsuario() {
      this.$emit('cerrarNuevoUsuario', null)
    },
    guardarUsuario() {
      /*      let platillo = {
              nombrePlatillo: this.nombrePlatillo,
              descripcionPlatillo: this.descripcionPlatillo,
              tipoPlatillo: this.tipoPlatillo,
              precioPlatillo: this.precionPlatillo,
              promocion: this.promocionPlatillo
            }*/

      /*axios.post('/guardarPlatillo', {
        datos: platillo
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
          })*/
    },
    // buscarPlatillos(itemTitle, queryText, item) {
    //   const textOne = item.raw.nombre.toLowerCase()
    //   const searchText = queryText.toLowerCase()
    //
    //   return textOne.indexOf(searchText) > -1
    // },
    // buscarPromociones(itemTitle, queryText, item) {
    //   const textOne = item.raw.tipo_promocion.toLowerCase()
    //   const searchText = queryText.toLowerCase()
    //
    //   return textOne.indexOf(searchText) > -1
    // },
    limpiarCampos() {
      this.nombres = ''
      this.apellidos = ''
      this.correo = ''
      this.rol = ''
    }

  },
  beforeCreate() {
    // Items have already been loaded
    axios.get('/rolUsuarios', {
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
