<template>
  <v-container>
    <div v-if="recipes.length > 0">
      <div v-for="recipe in recipes" :key="recipe.id">
        <ListItem :recipe="recipe" />
      </div>
    </div>
    <div v-else>
      <p>
        <b>Aktuell keine Rezepte vorhanden</b>
      </p>
    </div>
  </v-container>
</template>

<script>
import RecipeService from '@/services/RecipeService'
import ListItem from '@/components/recipes/ListItem.vue'
import { mapActions } from 'vuex'

export default {
  name: 'RecipeList',
  components: {
    ListItem
  },
  data () {
    return {
      recipes: []
    }
  },
  async mounted () {
    try {
      const response = await RecipeService.getRecipes()
      this.recipes = response.data
    } catch (error) {
      this.showSnackbar({
        text: 'Beim Abrufen der Rezepte ist leider ein Fehler aufgetreten!',
        color: 'error',
        icon: 'mdi-error'
      })
    }
  },
  methods: {
    ...mapActions({
      showSnackbar: 'snackbar/showSnackbar'
    }),
  }
}
</script>

<style scoped lang="scss">

</style>