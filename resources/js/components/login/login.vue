<template>
  <div style="margin-top: 10%">
    <v-img
        class="mx-auto my-6"
        max-width="228"
        src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
    ></v-img>
    <!--logo de la empresa / sistema-->
    <v-form v-model="validDatos" @submit.prevent="iniciarSesion" ref="form">
      <v-card
          class="mx-auto pa-12 pb-8"
          elevation="8"
          max-width="448"
          rounded="lg"
      >

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
      </v-card>
    </v-form>
  </div>
</template>
<script>
import sha256 from 'crypto-js/sha256';

export default {
  data: () => ({
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
    limpiar() {
      this.pass = ''
      this.user = ''
      this.$refs.form.reset()
    }
  }
}
</script>
