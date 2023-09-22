<template>
  <template>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent width="800">
        <v-form v-model="validDatos" @submit.prevent="agregarUsuario">
          <v-card>
            <v-card-title>
              <span class="text-h5">Editar Usuario</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6">
                    <v-text-field v-model="enviarUsuario.nombres" label="Nombres" variant="underlined"
                      :rules="nombresRule" counter="20" maxlength="20"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field v-model="enviarUsuario.apellidos" label="Apellidos|" variant="underlined"
                      :rules="apellidosRule" counter="20" maxlength="20"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field v-model="enviarUsuario.correo" label="Correo" variant="underlined" :rules="correoRule"
                      counter="20" maxlength="20"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-autocomplete :items="items" :custom-filter="buscarRol" item-title="nombre_rol" :loading="loading"
                      :rules="rolRule" v-model="enviarUsuario.nombre_rol" variant="underlined" label="Rol" hide-details
                      hide-selected item-text="nombre_rol" solo return-object></v-autocomplete>
                  </v-col>
                  <v-col>
                    <v-text-field v-model="contraseña" label="Contraseña" variant="underlined"
                      :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
                      density="compact" placeholder="Ingresa tu contraseña" prepend-inner-icon="mdi-lock-outline"
                      @click:append-inner="visible = !visible" counter="20" maxlength="20"></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-alert
                      icon="mdi-shield-lock-outline"
                      dense
                      outlined
                      prominent
                      text
                      type="info"
                  >
                    <ul>
                      <li class="pb-3">
                        Por las políticas de seguridad, se requiere que la contraseña cumpla con:
                        <ul>
                          <li>Tener como mínimo <strong>8</strong> caracteres.</li>
                          <li>Tener al menos <strong>1</strong> mayúscula, <strong>1</strong> minúscula, <strong>1</strong> número y <strong>1</strong>carácter especial.</li>
                          <li>Carácteres especiales permitidos: <strong>@$!%*?&</strong></li>
                        </ul>
                      </li>
                      <li>
                        Ejemplo <span class="font-italic font-weight-thin">(no use el ejemplo para establecer su contraseña)</span>: Hola2023*
                      </li>
                    </ul>
                  </v-alert>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn prepend-icon="mdi-cancel" color="#DD2C00" class="text-none text-subtitle-1" variant="flat"
                @click="cerrarEditarUsuario">
                Cerrar
              </v-btn>
              <v-btn prepend-icon="mdi-content-save" color="#1565C0" class="text-none text-subtitle-1" variant="flat"
                @click="guardarUsuarioEditado" :disabled="!validDatos">
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
import sha256 from 'crypto-js/sha256';
export default {
  name: "editarUsuario",
  data: () => ({
    dialog: true,
    nombres: '',
    apellidos: '',
    correo: '',
    rol: '',
    contraseña: '',
    visible: false,

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
      let pass = this.contraseña
      if (pass != '') {
        if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(pass))) {
          let title = "Error en contraseña"
          let message = "Tomar en cuenta el parametro indicado"
          this.$iziToast.warning(title,message)
          return;
        }
        pass= sha256(pass).toString()
      }
      axios.post('/guardarUsuarioEditado', {
        datos: this.enviarUsuario,
        contraseña: pass
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
      id_rol: Number,
      nombre_rol: String
    }
  }
}
</script>

<style scoped></style>
