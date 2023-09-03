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
                        counter="20"
                        maxlength="20"
                    ></v-text-field>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="6"
                  >
                    <v-text-field
                        v-model="apellidos"
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
                        v-model="correo"
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
                        v-model="rol"
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

<script setup>

</script>

<style scoped>

</style>
