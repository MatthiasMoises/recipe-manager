<template>
  <v-container>
    <div v-if="recipe">
      <v-row>
        <v-col>
          <v-row>
            <v-col>
              <h2>
                {{ recipe.name }}
              </h2>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              {{ recipeShortDescription }}
            </v-col>
          </v-row>
        </v-col>
        <v-col>
          <img :src="require('@/assets/default-placeholder.png')" width="300" height="300" alt="placeholder" />
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="2">
          <v-text-field
            type="number"
            label="Anzahl Personen"
            outlined
            v-model="multiplier"
            :rules="[rules.required, rules.positiveNumber]"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <b>Zutaten</b>
          <ul>
            <li v-for="(ingredient, index) in recipe.ingredients" :key="index">
              {{ (ingredient.amount * multiplier > 0) ? ingredient.amount * multiplier : '' }} {{ ingredient.unit }} {{ ingredient.name }}
            </li>
          </ul>
        </v-col>
      </v-row>
      <v-row v-if="hasTotalWeight">
        <v-col>
          <b>Gesamtgewicht: {{ recipe.total_weight * multiplier }} g</b>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <b>Zubereitungsschritte</b>
          <div v-for="(preparationStep, index) in recipe.preparation_steps" :key="index">
            <div>
              {{ ( index + 1) }}. Schritt
            </div>
            <div class="step-short-desc">
              {{ preparationStep.short_description }}
            </div>
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-row>
            <v-col>
              <b>Zubereitungszeit: {{ preparationTime }}</b>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <b>Kochzeit: {{ cookingTime }}</b>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          Erstellt am: {{ recipe.created_at | getHumanDateWithTime }}
        </v-col>
        <v-col>
          Aktualisiert am: {{ recipe.updated_at | getHumanDateWithTime }}
        </v-col>
      </v-row>
      <v-row class="actions">
        <v-col>
          <v-row>
            <v-col>
              <b>Aktionen</b>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-btn
                rounded
                color="success"
                dark
                @click="editRecipe"
              >
                Rezept bearbeiten
              </v-btn>
            </v-col>
            <v-col>
              <v-btn
                rounded
                color="error"
                dark
                @click="dialog = true"
              >
                Rezept löschen
              </v-btn>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </div>
    <div v-else>
      <v-row>
        <v-col>
          <p>Zu diesem Rezept konnte leider kein Inhalt gefunden werden</p>
        </v-col>
      </v-row>
    </div>
    <LoadingSpinner :loading="loading" />
    <DeleteDialog :dialog="dialog" @cancelDelete="dialog = false" @confirmDelete="deleteRecipe" />
  </v-container>
</template>

<script>
import LoadingSpinner from '@/components/helpers/LoadingSpinner.vue'
import DeleteDialog from '@/components/dialogs/DeleteDialog.vue'
import RecipeService from '@/services/RecipeService'
import { validationRules } from '@/helpers/ValidationRules'
import { mapActions } from 'vuex'

export default {
  name: 'ViewRecipe',
  components: {
    LoadingSpinner,
    DeleteDialog
  },
  data () {
    return {
      loading: false,
      dialog: false,
      multiplier: 1,
      recipe: null,
      recipeId: null,
      rules: validationRules
    }
  },
  computed: {
    hasTotalWeight () {
      if (this.recipe.total_weight * this.multiplier > 0) {
        return true
      }
      return false
    },
    recipeShortDescription () {
      if (this.recipe && this.recipe.short_description) {
        return this.recipe.short_description
      }
      return 'Keine Beschreibung vorhanden'
    },
    preparationTime () {
      if (this.recipe && this.recipe.preparation_time && this.recipe.preparation_time > 0) {
        return this.recipe.preparation_time + ' Minuten'
      }
      return 'Keine Angabe'
    },
    cookingTime () {
      if (this.recipe && this.recipe.cooking_time && this.recipe.cooking_time > 0) {
        return this.recipe.cooking_time + ' Minuten'
      }
      return 'Keine Angabe'
    }
  },
  async mounted () {
    try {
      this.recipeId = parseInt(this.$route.params.id)
      const response = await RecipeService.getRecipeById(this.recipeId)
      this.recipe = response.data
      this.multiplier = this.recipe.number_of_people
    } catch (error) {
      this.showSnackbar({
        text: `Es ist leider ein Fehler aufgetreten!`,
        color: 'error',
        icon: 'mdi-error'
      })
    }
  },
  methods: {
    ...mapActions({
      showSnackbar: 'snackbar/showSnackbar'
    }),
    editRecipe () {
      this.$router.push({ path: `/edit-recipe/${this.recipeId}`})
    },
    async deleteRecipe () {
      this.loading = true
      try {
        const response = await RecipeService.deleteRecipe(this.recipeId)
        if (response.status === 200) {
          this.showSnackbar({
            text: 'Erfolgreich gelöscht!',
            color: 'success',
            icon: 'mdi-info'
          })
          this.$router.push('/')
        }
      } catch (error) {
        this.showSnackbar({
          text: 'Beim Löschen ist leider ein Fehler aufgetreten!',
          color: 'error',
          icon: 'mdi-error'
        })
      }
      finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped lang="scss">

.step-short-desc {
  padding-left: 15px;
}

.actions {
  border-top: 1px solid orange;
}

</style>
