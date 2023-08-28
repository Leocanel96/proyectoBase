<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialogEditarPlatillo"
                persistent
                width="800"
            >
                <v-form v-model="validDatos" @submit.prevent="agregarPlatillo">
                    <v-card>
                        <v-card-title>
                            <span class="text-h5 font-weight-black">Editar Platillo {{ enviarPlatillo.nombre_platillo }}</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        sm="6"

                                    >
                                        <v-text-field
                                            v-model="enviarPlatillo.nombre_platillo"
                                            label="Nombre del platillo"
                                            variant="underlined"
                                            :rules="nombrePlatilloRule"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-text-field
                                            v-model="enviarPlatillo.descripcion_platillo"
                                            label="Descripción del platillo"
                                            variant="underlined"
                                            :rules="descripcionPlatilloRule"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-autocomplete
                                            :items="items"
                                            :custom-filter="buscarPlatillos"
                                            item-title="nombre"
                                            :loading="loading"
                                            :rules="tipoPlatilloRule"
                                            v-model="enviarPlatillo.nombre"
                                            variant="underlined"
                                            label="Tipo pizza"
                                            hide-details
                                            hide-selected
                                            item-text="nombre"
                                            solo
                                            return-object
                                        ></v-autocomplete>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-text-field
                                            v-model="enviarPlatillo.precio"
                                            label="Precio Platillo"
                                            variant="underlined"
                                            :rules="precioRule"
                                            prefix="Q"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        sm="6"
                                    >
                                        <v-autocomplete
                                            :items="promociones"
                                            :custom-filter="buscarPromociones"
                                            item-title="tipo_promocion"
                                            :loading="loading2"
                                            :rules="promocionRule"
                                            v-model="enviarPlatillo.tipo_promocion"
                                            variant="underlined"
                                            label="Promociones"
                                            hide-details
                                            hide-selected
                                            item-text="tipo_promocion"
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
                                @click="cerrarEditarPlatillo"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                prepend-icon="mdi-content-save"
                                color="#1565C0"
                                class="text-none text-subtitle-1"
                                variant="flat"
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
    name: "editarPlatillo",
    data: () => ({
        dialogEditarPlatillo: true,
        nombrePlatillo: '',
        descripcionPlatillo: '',
        tipoPlatillo: '',
        precionPlatillo: '',
        promocionPlatillo: '',
        //autocomplete
        loading: false,
        items: [],

        //promociones
        promociones: [],
        loading2: false,

        //formulario
        validDatos: false,
        agregarPlatillo: false,

        // Reglas de las cajas de texto
        nombrePlatilloRule: [
            v => !!v || 'Nombre del platillo es requerido',
        ],
        descripcionPlatilloRule: [
            v => !!v || 'Descripciópn del platillo es requerido.',
        ],
        precioRule: [
            v => !!v || 'El precio del platillo es requerido',
            v => v > isNaN(v) || 'El valor debe ser numérico',
        ],
        tipoPlatilloRule: [
            v => !!v || 'Tipo de platillo es requerido.',
        ],
        promocionRule: [
            v => !!v || 'Promoción es requerido.',
        ],
    }),
    methods: {
        cerrarEditarPlatillo() {
            this.$emit('cerrarEditarPlatillo')
        },
        guardarPlatillo() {
        },

        buscarPlatillos(itemTitle, queryText, item) {
            const textOne = item.raw.nombre.toLowerCase()
            const searchText = queryText.toLowerCase()

            return textOne.indexOf(searchText) > -1
        },
        buscarPromociones(itemTitle, queryText, item) {
            const textOne = item.raw.tipo_promocion.toLowerCase()
            const searchText = queryText.toLowerCase()

            return textOne.indexOf(searchText) > -1
        },
    },
    props: {
        enviarPlatillo: []
    }
}
</script>
<style scoped>

</style>
