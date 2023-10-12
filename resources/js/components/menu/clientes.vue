<template>
  <div>
    <v-app id="inspire">
      <v-app-bar
          color="#FFAB91"
      >
        <!--      <v-app-bar-nav-icon></v-app-bar-nav-icon>-->
        <v-icon
            end
            icon="mdi-pizza"
        ></v-icon>
        <v-app-bar-title
            color="white"
        >Leo's Pizza
        </v-app-bar-title>


        <v-spacer></v-spacer>


        <v-btn icon>
          <v-icon>mdi-cart</v-icon>
        </v-btn>

        <v-btn icon>
          <v-icon
              @click="login"
          >mdi-account-arrow-right
          </v-icon>
        </v-btn>
      </v-app-bar>

      <v-main>
        <v-card
            style="margin-top: 3%"
            max-width="1000"
            class="mx-auto"
        >
          <v-carousel hide-delimiters>
            <v-carousel-item
                v-for="(item,i) in items"
                :key="i"
                :src="item.src"
                cover
            ></v-carousel-item>
          </v-carousel>
        </v-card>

        <v-container>
          <v-row>
            <v-col
                v-for="({nombre_platillo, ruta_imagen, descripcion_platillo}, index) in platillos"
                :key="index"
                cols="4"
            >
              <v-hover v-slot="{ isHovering, props }">

                <v-card
                    height="250"
                    width="300"
                    class="mx-auto"
                    color="grey-lighten-4"
                    v-bind="props"
                >
                  <v-container
                      style="text-align: center"
                  >
                    <span><b>{{ nombre_platillo }}</b></span>
                  </v-container>
                  <v-img
                      class="mx-auto my-6"
                      :src="ruta_imagen+`?image=${index * 5 + 10}`"
                      max-width="500"
                      :lazy-src="ruta_imagen+`?image=${index * 5 + 10}`"
                  >
                    <v-expand-transition>
                      <div
                          v-if="isHovering"
                          class="d-flex transition-fast-in-fast-out bg-deep-orange-lighten-4 v-card--reveal"
                          style="height: 100%;"
                      >
                        <v-container>
                          <span style="text-align: justify"><b>{{ descripcion_platillo }}</b></span>
                        </v-container>
                        <v-spacer></v-spacer>
                        <v-btn
                            class="ma-2"
                            color="#E64A19"
                            icon="mdi-cart"
                            @click="agregarCarrito"
                        ></v-btn>
                      </div>
                    </v-expand-transition>
                  </v-img>

                </v-card>

              </v-hover>

            </v-col>
          </v-row>
        </v-container>
      </v-main>
    </v-app>
    <inicio-sesion v-if="iniciarSesion" @cerrarInicioSesion="cerrarInicioSesion"></inicio-sesion>
  </div>
</template>
<script>
import inicioSesion from "@/components/dialogs/inicioSesion.vue";

export default {
  name: "clientes",
  components: {inicioSesion},
  data() {


    return {
      iniciarSesion: false,
      items: [
        {
          src: '/storage/img/carrusel/carrusel1.jpg',
        },
        {
          src: '/storage/img/carrusel/carrusel2.jpg',
        },
        {
          src: '/storage/img/carrusel/carrusel3.jpg',
        },
      ],
      platillos: [],
    }
  },
  methods: {
    login() {
      this.iniciarSesion = true
    },
    cerrarInicioSesion() {
      this.iniciarSesion = false
    },
    agregarCarrito() {

    }

  },
  beforeCreate() {
    axios.get('/obtenerPlatillosClientes')
        .then(res => {
          this.platillos = res.data.platillos
          console.log(JSON.stringify(this.platillos[0]['ruta_imagen'], null, 2))
        })
        .catch(err => {
          this.$iziToast.error(err)
        })
        .finally(() => {

        })
  },

}
</script>
<style scoped>
.v-card--reveal {
  align-items: center;
  bottom: 0;
  justify-content: center;
  opacity: .9;
  position: absolute;
  width: 100%;
}

.centrar {
  text-align: center;
}
</style>
