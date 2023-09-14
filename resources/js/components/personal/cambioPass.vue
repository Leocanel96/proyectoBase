<template>
  <v-container>
    <h1>Cambio de contraseña</h1>
    <v-form v-model="valid" @submit.prevent="cambiarPass" ref="form">

      <v-card
          class="mx-auto"
          max-width="700"
          outlined
          color=""
      >
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
              </ul>
            </li>
            <li>
              Ejemplo <span class="font-italic font-weight-thin">(no use el ejemplo para establecer su contraseña)</span>: miPAss11
            </li>
          </ul>
        </v-alert>
        <v-card-title>
          <span class="">Por favor ingrese los siguientes datos:</span>
        </v-card-title>
        <v-card-text>
          <v-container>

            <v-row>
              <v-col cols="12">
                <v-text-field
                    label="Contraseña actual"
                    hint="La mísma que utilizas para ingresar al sistema."
                    persistent-hint
                    v-model="contraseñaActual"
                    :rules="contraseñaActualRule"
                    @keyup.enter="setPassword"
                    :append-inner-icon="visibleContraseñaActual ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visibleContraseñaActual ? 'text' : 'password'"
                    @click:append-inner="visibleContraseñaActual = !visibleContraseñaActual"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                    label="Nueva contraseña"
                    v-model="nuevaContraseña"
                    :rules="contraseñaNuevaRule"
                    @keyup.enter="setPassword"
                    :append-inner-icon="visibleNuevaContraseña ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visibleNuevaContraseña ? 'text' : 'password'"
                    @click:append-inner="visibleNuevaContraseña = !visibleNuevaContraseña"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                    label="Confirme su nueva contraseña"
                    v-model="confirmarNuevaContraseña"
                    @keyup.enter="setPassword"
                    :rules="confirmarContraseñaNuevaRule"
                    :append-inner-icon="visibleConfirmarNuevaContraseña ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visibleConfirmarNuevaContraseña ? 'text' : 'password'"
                    @click:append-inner="visibleConfirmarNuevaContraseña = !visibleConfirmarNuevaContraseña"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <small>*Todos los campos son obligatorios</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
              prepend-icon="mdi-broom"
              color="#DD2C00"
              class="text-none text-subtitle-1"
              variant="flat"
              @click="limpiar"
          >
            Limpiar
          </v-btn>
          <v-btn
              prepend-icon="mdi-content-save"
              color="#1565C0"
              class="text-none text-subtitle-1"
              variant="flat"
              :disabled="!valid"
              @click="setPassword"
              :loading="loading"
          >
            Cambiar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-container>
</template>

<script>
export default {
  name: "cambioPass",
  data: () => ({
    visibleContraseñaActual: false,
    visibleNuevaContraseña: false,
    visibleConfirmarNuevaContraseña: false,

    //formulario
    valid: false,
    cambiarPass: false,

    contraseñaActual: '',
    nuevaContraseña: '',
    confirmarNuevaContraseña: '',
    loading: false,

    // Reglas de las cajas de texto
    contraseñaActualRule: [
      v => !!v || 'Contraseña actual es requerida.',
    ],
    contraseñaNuevaRule: [
      v => !!v || 'Contraseña nueva es requerida.',
    ],
    confirmarContraseñaNuevaRule: [
      v => !!v || 'Confirmar contraseña nueva es requerida.',
    ]

  }),

  methods: {
    setPassword() {
      if (this.nuevaContraseña !== this.confirmarNuevaContraseña) {
        this.$iziToast.info("Atención", "La nueva contraseña y su confirmación no coinciden.")
        return
      }

      this.loading = true

      let credenciales = {
        actual: this.contraseñaActual,
        nueva: this.nuevaContraseña,
        confirmacion: this.confirmarNuevaContraseña
      }

      axios.post('/cambiarPassword', {
        datos: credenciales
      })
          .then(res => {
            // this.$iziToast.msg(res, this.$Progress);
            // this.form = Object.assign({}, this.defaultForm)
          })
          .catch(err => {
            this.$iziToast.fail(err, this.$Progress)
          })
          .finally(() => {
            this.loading = false
            this.$refs.form.resetValidation()
          })
    },
    limpiar() {
      this.contraseñaActual = ''
      this.nuevaContraseña = ''
      this.confirmarNuevaContraseña = ''
      this.$refs.form.reset()
    }
  },
}
</script>
<style scoped>

</style>
