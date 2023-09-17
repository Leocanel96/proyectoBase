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
                        v-model="enviarUsuario.nombres"
                        label="Nombres"
                        variant="underlined"
                        :rules="nombresRule"
                        counter="20"
                        maxlength="20"
                    ></v-text-field>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-text-field
                        v-model="enviarUsuario.apellidos"
                        label="Apellidos|"
                        variant="underlined"
                        :rules="apellidosRule"
                        counter="20"
                        maxlength="20"
                    ></v-text-field>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-text-field
                        v-model="enviarUsuario.correo"
                        label="Correo"
                        variant="underlined"
                        :rules="correoRule"
                        counter="20"
                        maxlength="20"
                    ></v-text-field>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-autocomplete
                        :items="items"
                        :custom-filter="buscarRol"
                        item-title="nombre_rol"
                        :loading="loading"
                        :rules="rolRule"
                        v-model="enviarUsuario.nombre_rol"
                        variant="underlined"
                        label="Rol"
                        hide-details
                        hide-selected
                        item-text="nombre_rol"
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
                  @click="cerrarEditarUsuario"
              >
                Cerrar
              </v-btn>
              <v-btn
                  prepend-icon="mdi-content-save"
                  color="#1565C0"
                  class="text-none text-subtitle-1"
                  variant="flat"
                  @click="guardarUsuarioEditado"
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
  name: "editarUsuario",
  data: () => ({
    dialog: true,
    nombres: '',
    apellidos: '',
    correo: '',
    rol: '',

    //autocomplete
    loading: false,
    items: [],

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
    cerrarEditarUsuario() {
      this.$emit('cerrarUsuarioEditado', null)
    },
    guardarUsuarioEditado() {
      axios.post('/guardarUsuarioEditado', {
        datos: this.enviarUsuario
      })
          .then(res => {
            this.loading = false
            this.$iziToast.success(res)
            this.limpiarCampos()
            this.cerrarEditarUsuario()
          })
          .catch(err => {
            this.$iziToast.error(err)
          })
          .finally(() => {
            this.loading = false
          })
    },
    buscarRol(itemTitle, queryText, item) {
      const textOne = item.raw.nombre_rol.toLowerCase()
      const searchText = queryText.toLowerCase()

      return textOne.indexOf(searchText) > -1
    },
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
          this.items = res.data.rolesEncontrados
        })
        .catch(err => {
          this.loading = false
        })
        .finally(() => {
          this.loading = false
        })
  },
  props: {
    enviarUsuario: {
      id_usuario: Number,
      nombres: String,
      apellidos: String,
      correo: String,
      id_rol: Number
    }
  }
}
</script>

<style scoped>

</style>
