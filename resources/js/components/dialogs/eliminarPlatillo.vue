<template>
  <template>
    <v-row justify="center">
      <v-dialog
          v-model="dialogEliminarPlatillo"
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
                  <li><h4>Al realizar esta acción, no se podrá revertir.</h4></li>
                  <br>
                  <li><h3 style="text-align: center"><b>¿Está seguro que desea eliminar este platillo?</b></h3></li>
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
                @click="cancelarEliminarPlatillo"
            >
              Cancelar
            </v-btn>
            <v-btn
                prepend-icon="mdi-delete-empty"
                color="#1565C0"
                class="text-none text-subtitle-1"
                variant="flat"
                @click="eliminarPlatillo(enviarEliminarPlatillo)"
            >
              Aceptar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </template>
</template>

<script>
export default {
  name: "eliminarPlatillo",
  data: () => ({
    dialogEliminarPlatillo: true,
  }),
  methods: {
    cancelarEliminarPlatillo() {
      this.cerrarEliminarPlatillo()
    },
    cerrarEliminarPlatillo() {
      this.$emit('cerrarEliminarPlatillo', null)
    },
    eliminarPlatillo(platillo) {
      let platilloEliminar = {
        idPlatillo: platillo.id_platillo,
      }

      axios.post('/eliminarPlatillo', {
        datos: platilloEliminar
      })
          .then(res => {
            this.loading = false
            this.$iziToast.success(res)
            this.cerrarEliminarPlatillo()
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
    enviarEliminarPlatillo: {
      id_platillo: Number
    }
  },
}
</script>
<style scoped>

</style>
