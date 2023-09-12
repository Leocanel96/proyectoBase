<template>
  <template>
    <v-row justify="center">
      <v-dialog
          v-model="dialogDesactivarRol"
          persistent
          width="800"
      >

        <v-card>

          <v-card-text>
            <v-container>
              <v-alert
                  type="warning"
                  border="start"
                  variant="tonal"
                  color="#01579B"
                  title="Atención"
              >
                <ul>
                  <li><h4>Al realizar esta acción, se desactiva el rol.</h4></li>
                  <br>
                  <li><h3 style="text-align: center"><b>¿Está seguro que desea desactivar este rol?</b></h3></li>
                </ul>
              </v-alert>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                prepend-icon="mdi-cancel"
                color="#DD2C00"
                class="text-none text-subtitle-1"
                variant="flat"
                @click="cancelarDesactivarRol"
            >
              Cancelar
            </v-btn>
            <v-btn
                prepend-icon="mdi-delete-empty"
                color="#1565C0"
                class="text-none text-subtitle-1"
                variant="flat"
                @click="desactivarRol(enviarDesactivarRol)"
            >
              Desactivar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </template>
</template>

<script>
export default {
  name: "desactivarRol",
  data: () => ({
    dialogDesactivarRol: true,
  }),
  methods: {
    cancelarDesactivarRol() {
      this.cerrarDesactivarRol()
    },
    cerrarDesactivarRol() {
      this.$emit('cerrarDesactivarRol', null)
    },
    desactivarRol(rol) {
      let rolDesactivar = {
        idRol: rol.id_rol,
      }
      axios.post('/desactivarRol', {
        datos: rolDesactivar
      })
          .then(res => {
            this.loading = false
            this.$iziToast.success(res)
            this.cerrarDesactivarRol()
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
    enviarDesactivarRol: {
      id_rol: Number
    }
  },
}
</script>

<style scoped>

</style>
