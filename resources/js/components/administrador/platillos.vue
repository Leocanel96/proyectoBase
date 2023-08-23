<template>
  <div>
    <v-card
        elevation="12"
        class="mx-auto my-12"
        max-width="1500"
    >
      <v-container>
        <v-card-title>
          Nutrition
          <v-spacer></v-spacer>
          <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="desserts"
            :search="search"
        ></v-data-table>
      </v-container>
    </v-card>
  </div>
</template>

<script>
export default {
  name: "platillos",
  data() {
    return {
      search: '',
      headers: [
        {
          align: 'start',
          key: 'name',
          sortable: false,
          title: 'Dessert (100g serving)',
        },
        {key: 'calories', title: 'Calories'},
        {key: 'fat', title: 'Fat (g)'},
        {key: 'carbs', title: 'Carbs (g)'},
        {key: 'protein', title: 'Protein (g)'},
        {key: 'iron', title: 'Iron (%)'},
      ],
      desserts: [
        {
          name: 'Frozen Yogurt',
          calories: 159,
          fat: 6.0,
          carbs: 24,
          protein: 4.0,
          iron: 1,
        },
      ],
    }
  },
}
</script>

<style scoped>

</style>
