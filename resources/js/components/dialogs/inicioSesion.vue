<template>
  <template>
    <v-row justify="center">
      <v-dialog
          v-model="dialoginicioSesion"
          persistent
          width="500"
      >
        <div style="margin-top: 10%">

          <!--logo de la empresa / sistema-->
          <v-form v-model="validDatos" @submit.prevent="iniciarSesion" ref="form">
            <v-card
                class="mx-auto pa-12 pb-8"
                elevation="8"
                max-width="400"
                rounded="lg"
            >
              <v-img
                  class="mx-auto my-6"
                  max-width="100"
                  src="/storage/img/carrusel/chef.jpg"
              ></v-img>
              <div class="text-subtitle-1 text-medium-emphasis">Usuario</div>

              <v-text-field
                  density="compact"
                  placeholder="Ingresa tu usuario "
                  prepend-inner-icon="mdi-email-outline"
                  variant="outlined"
                  v-model="user"
                  :rules="usuarioLoginRule"
                  @keyup.enter="login"
              ></v-text-field>

              <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                Contraseña
              </div>
              <v-text-field
                  :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                  :type="visible ? 'text' : 'password'"
                  density="compact"
                  placeholder="Ingresa tu contraseña"
                  prepend-inner-icon="mdi-lock-outline"
                  variant="outlined"
                  @click:append-inner="visible = !visible"
                  v-model="pass"
                  :rules="reglasLoginRule"
                  @keyup.enter="login"
              ></v-text-field>
              <v-btn
                  block
                  class="mb-8"
                  color="blue"
                  size="large"
                  variant="tonal"
                  @click="login"
                  :disabled="!validDatos"
              >
                Ingresar
              </v-btn>
              <v-card-actions>
                <v-btn color="warning" block @click="cerrarInicioSesion">Cerrar</v-btn>
              </v-card-actions>

            </v-card>
          </v-form>
        </div>
      </v-dialog>
    </v-row>
  </template>
</template>

<script>
import sha256 from "crypto-js/sha256.js";

export default {
  name: "login",
  data: () => ({
    dialoginicioSesion: true,
    visible: false,
    pass: '',
    user: '',

    //formulario
    validDatos: '',
    iniciarSesion: false,

    // Reglas para el login
    reglasLoginRule: [
      v => !!v || 'Es requerido',
      v => (v || '').indexOf(' ') < 0 || 'No se permiten espacios'
    ],
    usuarioLoginRule: [
      v => !!v || 'Es requerido',
      v => (v || '').indexOf(' ') < 0 || 'No se permiten espacios',
      v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Correo debe ser valido.'
    ],

  }),
  methods: {
    login() {
      let parametros = {
        pass: sha256(this.pass).toString(),
        user: this.user
      }
      axios.post('/login', parametros)
          .then(res => {
            this.$iziToast.success(res)
            localStorage.setItem('user', JSON.stringify(res.data, null, 2))
            this.limpiar()
            location.reload()
          })
          .catch(err => {
            this.$iziToast.error(err)

          })
          .finally(() => {
            this.limpiar()
          })
    },
    cerrarInicioSesion() {
      this.$emit('cerrarInicioSesion')
    },
    limpiar() {
      this.pass = ''
      this.user = ''
      this.$refs.form.reset()
    }
  }

}
</script>

<style scoped>

</style>
