<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialog"
                persistent
                width="800"
            >
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Agregar platillo</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                    sm="6"

                                >
                                    <v-text-field
                                        v-model="nombrePlatillo"
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
                                        v-model="descripcionPlatillo"
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
                                        v-model="precionPlatillo"
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
                            color="blue-darken-1"
                            variant="text"
                            @click="cerrarAgregarPlatillos"
                        >
                            Close
                        </v-btn>
                        <v-btn
                            color="blue-darken-1"
                            variant="text"
                            @click="guardarPlatillo"
                        >
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </template>
</template>

<script>
export default {
    name: "agregarPlatillos",
    data: () => ({
        dialog: true,
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
    }),
    watch: {
        /*search(val) {
            // Items have already been loaded
            this.isLoading = true
            axios.get('/tipoPlatillos', {
                params: {
                    nombre: this.search
                }
            })
                .then(res => {
                    this.items = res.data.tipoPlatillos
                    this.querySelections(this.search)
                })
                .catch(err => {

                    this.isLoading = false
                })
                .finally(() => {
                    this.isLoading = false
                })
        }*/
    },
    methods: {
        cerrarAgregarPlatillos() {
            this.$emit('cerrarNuevoPlatillo')
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
    beforeCreate() {
        // Items have already been loaded
        axios.get('/tipoPlatillos', {
            params: {
                nombre: this.search
            }
        })
            .then(res => {
                this.loading = true
                this.items = res.data.respuesta['tipoPlatillos']
                this.promociones = res.data.respuesta['promociones']
            })
            .catch(err => {
                this.loading = false
            })
            .finally(() => {
                this.loading = false
            })
    }
}
</script>

<style scoped>

</style>
