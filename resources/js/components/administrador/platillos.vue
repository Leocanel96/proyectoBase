<template>
    <div>
        <v-card
            elevation="12"
            class="mx-auto my-12"
            max-width="1000"
        >
            <v-table

            >
                <thead>
                <tr>
                    <th class="text-left">
                        Nombre del platillo
                    </th>
                    <th class="text-left">
                        Descripción
                    </th>
                    <th class="text-left">
                        Precio
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="item in desserts"
                    :key="item.name"
                >
                    <td>{{ item.nombrePlatillo }}</td>
                    <td>{{ item.descripcionPlatillo }}</td>
                    <td>{{ item.precioPlatillo }}</td>
                </tr>
                </tbody>
            </v-table>

        </v-card>
    </div>
</template>

<script>
export default {
    name: "platillos",
    data() {
        return {
            desserts: [
                {
                    nombrePlatillo: 'Frozen Yogurt',
                    descripcionPlatillo: 159,
                    precioPlatillo: 159,
                },
            ],
        }
    },
    methods: {},
    beforeCreate() {
        axios.get('/obtenerPlatillosCreados')
            .then(res => {
                console.log(JSON.stringify(res.data.solicitudesCreadas.data, null, 2))
            })
            .catch(err => {
                console.log("esta en el catch del error")
            })
            .finally(() => {
                console.log("esta en el finally")
            })
    },
}
</script>

<style scoped>

</style>
