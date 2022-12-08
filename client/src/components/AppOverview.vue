<template>
  <v-container>
    <v-row class="text-center">
      <v-col cols="12">
        <v-btn
          class="btn-create-recipe"
          rounded
          color="primary"
          dark
          @click="createNewRecipe"
        >
          Neues Rezept anlegen
        </v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <h3>
          Alle Rezepte
        </h3>
      </v-col>
    </v-row>
    <RecipeList />
  </v-container>
</template>

<script>
import RecipeList from '@/components/recipes/RecipeList.vue'

export default {
  name: 'AppOverview',
  components: {
    RecipeList
  },
  methods: {
    createNewRecipe () {
      this.$router.push({ name: 'add-recipe' })
    }
  }
}
</script>

<style scoped lang="scss">

.btn-create-recipe {
  margin: 25px;
}

</style>
