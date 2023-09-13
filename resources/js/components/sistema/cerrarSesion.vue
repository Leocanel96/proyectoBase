<template>
    <h1>Cerrar Sesión </h1>
</template>

<script>
export default {
    name: "cerrarSesion",
    methods: {},
    beforeCreate() {
        // cerrar sesion
        axios.get('/cerrarSesion', {
            params: {
                nombre: this.search
            }
        })
            .then(res => {
                this.loading = true
                this.items = res.data.respuesta['tipoPlatillos']
                this.promociones = res.data.respuesta['promociones']
                this.platilloEditado = this.enviarPlatillo
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
