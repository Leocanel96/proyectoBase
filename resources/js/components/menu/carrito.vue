<template>
    <template>
        <v-row justify="center">
            <v-dialog
                v-model="dialogVerCarrito"
                persistent
                width="800"
            >
                <v-container>
                    <v-card class="card-con-scroll">
                        <v-container>
                            <v-card-title style="text-align: center">
                                <span class="text-h6">Carrito</span>
                            </v-card-title>
                            <v-row>
                                <v-col
                                    v-for="(item, index) in enviarCarrito"
                                    :key="item.idPlatillo"
                                    cols="12"
                                    md="4"
                                >
                                    <v-card
                                        :title="item.nombre"
                                        :subtitle="item.descripcion"
                                        :text="'Q. '+item.precio"
                                    >
                                        <div class="contenedor">
                                            <v-img
                                                cover
                                                :src="item.imagen"
                                            ></v-img>
                                        </div>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-icon icon="mdi-delete-empty"
                                                    dark
                                                    @click="eliminarPlatilloCarrito(item, index)"
                                            >
                                            </v-icon>
                                        </v-card-actions>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-container>

                        <v-card-title>
                            <div></div>
                            Total a pagar: <b>Q. {{ sumaTotal }} </b>
                        </v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue-darken-1"
                                variant="text"
                                @click="cerrar"
                            >
                                Seguir comprando
                            </v-btn>
                            <v-btn
                                color="blue-darken-1"
                                variant="text"
                                @click="pagar"
                            >
                                Pagar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-container>
            </v-dialog>
        </v-row>


    </template>
</template>

<script>

export default {
    name: "carrito",
    data: () => ({
        dialogVerCarrito: true,
        sumaTotal: '',
    }),
    methods: {
        eliminarPlatilloCarrito(platillo, index) {
            this.enviarCarrito.splice(index, 1);
            this.sumaPedido()
        },
        cerrar() {
            this.$emit('contadorCarritoActual', null)
            this.$emit('cerrarCarrito', null)
        },
        pagar() {

        },
        sumaPedido() {
            this.sumaTotal = this.enviarCarrito.reduce((total, element) => total + parseInt(element.precio, 10), 0)
        }
    },
    mounted() {
        this.sumaPedido()
    },
    props: {
        enviarCarrito: {
            idPlatillo: Number,
            nombre: String,
            imagen: String,
            descripcion: String,
            precio: Number
        }
    }
}
</script>


<style scoped>
.contenedor {
    display: flex;
    justify-content: center; /* Centra horizontalmente */
    align-items: center; /* Centra verticalmente */
}

.imagen {
    max-width: 100%; /* Ajusta el tamaño de la imagen al contenedor */
    max-height: 100%; /* Ajusta el tamaño de la imagen al contenedor */
}

.card-con-scroll {
    max-height: 500px; /* Define la altura máxima que desees para el v-card */
    overflow: auto; /* Agrega la barra de desplazamiento si el contenido excede la altura máxima */
}

</style>
