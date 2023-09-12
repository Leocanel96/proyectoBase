<template>
  <div>
    <v-img
        class="mx-auto my-6"
        max-width="228"
        src=""
    ></v-img>
    <!--logo de la empresa / sistema-->
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
      ></v-text-field>
      <v-btn
          block
          class="mb-8"
          color="blue"
          size="large"
          variant="tonal"
          @click="login"
      >
        Ingresar
      </v-btn>
    </v-card>
  </div>
</template>
<script>
import sha256 from 'crypto-js/sha256';
import * as crypto from "crypto";

export default {
  data: () => ({
    visible: false,
    pass: '',
    user: '',
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
            location.reload()
          })
          .catch(err => {
            this.$iziToast.error(err)
          })
          .finally(() => {
            console.log("logueado")
          })
    }
  }
}
</script>
