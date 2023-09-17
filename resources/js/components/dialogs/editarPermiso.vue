<template>
  <template>
    <v-row justify="center">
      <v-dialog
          v-model="dialogEditarPermiso"
          persistent
          width="600"
      >
        <v-form v-model="validDatos" @submit.prevent="agregarPermiso">
          <v-card>
            <v-card-title>
              <span class="text-h5 font-weight-black">Permiso</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                      cols="12"
                  >
                    <v-text-field
                        v-model="enviarPermiso.nombre_permiso"
                        label="Nombre del permiso"
                        variant="underlined"
                        :rules="nombrePermisoRule"
                        counter="20"
                        maxlength="20"
                    ></v-text-field>
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
                  @click="cerrarEditarPermiso"
              >
                Cerrar
              </v-btn>
              <v-btn
                  prepend-icon="mdi-content-save"
                  color="#1565C0"
                  class="text-none text-subtitle-1"
                  variant="flat"
                  :disabled="!validDatos"
                  @click="guardarPermisoEditado"
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
  name: "editarPermiso",
  data: () => ({
    dialogEditarPermiso: true,
    nombrePermiso: '',
    //formulario
    validDatos: false,
    agregarPermiso: false,

    // Reglas de las cajas de texto
    nombrePermisoRule: [
      v => !!v || 'Nombre del Permiso es requerido',
    ]
  }),
  methods: {
    cerrarEditarPermiso() {
      this.$emit('cerrarEditarPermiso')
    },
    guardarPermisoEditado() {
      axios.post('/guardarPermisoEditado', {
        datos: this.enviarPermiso
      })
          .then(res => {
            this.loading = false
            this.$iziToast.success(res)
            this.cerrarEditarPermiso()
          })
          .catch(err => {
            this.$iziToast.error(err)
          })
          .finally(() => {
            this.loading = false
          })
    }
  },
  props: {
    enviarPermiso: {
      nombre_permiso: String
    }
  }
}
</script>


<style scoped>

</style>
