<template>
  <FormHelper>
    <div slot="form-header">
      <h3>Neues Rezept</h3>
    </div>
    <div slot="form-fields">
      <v-form ref="form">
        <v-row>
          <v-col>
            <v-text-field
              label="Name"
              outlined
              v-model="recipe.name"
              :rules="[rules.required]"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-textarea
              outlined
              name="input-7-4"
              label="Kurzbeschreibung"
              v-model="recipe.short_description"
              :rules="[rules.counter]"
            ></v-textarea>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              type="number"
              label="Anzahl Personen"
              outlined
              v-model="recipe.number_of_people"
              :rules="[rules.required, rules.positiveNumber]"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <b>Zutaten</b>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            Zutat hinzufügen
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="2">
            <v-text-field
              type="number"
              outlined
              placeholder="Menge"
              v-model="ingredient.amount"
            ></v-text-field>
          </v-col>
          <v-col cols="2">
            <v-select
              label="Einheit"
              :items="allowedUnits"
              outlined
              v-model="ingredient.unit"
            ></v-select>
          </v-col>
          <v-col cols="6">
            <v-combobox
              v-model="ingredient.name"
              :items="ingredientItems"
              :search-input.sync="search"
              :rules="[rules.required]"
              cache-items
              outlined
              placeholder="Zutat"
              hide-no-data
            ></v-combobox>
          </v-col>
          <v-col cols="2">
            <v-btn
              depressed
              color="primary"
              :disabled="!ingredientBtnStatus"
              @click.prevent="addIngredient"
            >
              Hinzufügen
            </v-btn>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <div v-if="(recipe.ingredients.length > 0)">
              <IngredientListItem 
                v-for="(ing, index) in recipe.ingredients" 
                :key="index" 
                :singleIngredient="ing" 
                :ingredientIndex="index" 
                @ingredientRemoved="removeIngredient"
              />
            </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <h3>Zubereitungsschritte</h3>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-textarea
              outlined
              name="input-7-4"
              label="Kurzbeschreibung"
              :rules="[rules.required]"
              v-model="preparationStep.short_description"
            ></v-textarea>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              type="number"
              label="Zubereitungszeit"
              outlined
              v-model="preparationStep.preparation_time"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              type="number"
              label="Kochzeit"
              outlined
              v-model="preparationStep.cooking_time"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="text-right">
            <v-btn
              depressed
              color="primary"
              :disabled="!preparationStepBtnStatus"
              @click="addPreparationStep"
            >
              Hinzufügen
            </v-btn>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <div v-if="(recipe.preparation_steps.length > 0)">
              <PreparationStepListItem
                v-for="(step, index) in recipe.preparation_steps"
                :key="index" 
                :singleStep="step" 
                :stepIndex="index"
                @preparationStepRemoved="removePreparationStep"
              />
            </div>
          </v-col>
        </v-row>
      </v-form>
    </div>
    <div slot="form-controls">
      <v-row>
        <v-col class="text-center">
          <v-btn
            depressed
            color="primary"
            @click.prevent="handleSubmit"
            :disabled="!formValid"
          >
            Rezept speichern
          </v-btn>
        </v-col>
      </v-row>
    </div>
    <div slot="form-process-elements">
      <LoadingSpinner :loading="loading" />
    </div>
  </FormHelper>
</template>

<script>
import FormHelper from '@/slots/FormHelper.vue'
import LoadingSpinner from '@/components/helpers/LoadingSpinner.vue'
import IngredientListItem from '@/components/recipes/IngredientListItem.vue'
import PreparationStepListItem from '@/components/recipes/PreparationStepListItem.vue'
import RecipeService from '@/services/RecipeService'
import IngredientService from '@/services/IngredientService'
import { validationRules } from '@/helpers/ValidationRules'
import { mapActions } from 'vuex'

export default {
  name: 'EditRecipe',
  components: {
    FormHelper,
    LoadingSpinner,
    IngredientListItem,
    PreparationStepListItem
  },
  data () {
    return {
      mode: 'add',
      loading: false,
      allowedUnits: ['g', 'mg', 'Kg', 'EL', 'TL', 'Tasse'],
      recipe: {
        name: '',
        short_description: '',
        number_of_people: 1,
        ingredients: [],
        preparation_steps: []
      },
      ingredient: {
        name: '',
        unit: null,
        amount: null
      },
      preparationStep: {
        short_description: '',
        preparation_time: null,
        cooking_time: null
      },
      search: null,
      ingredientItems: [],
      rules: validationRules
    }
  },
  computed: {
    routeId () {
      return this.$route.params.id ?? null
    },
    ingredientBtnStatus () {
      return this.ingredient.name !== '' ? true : false
    },
    preparationStepBtnStatus () {
      return this.preparationStep.short_description !== '' ? true : false
    },
    formValid () {
      if (
        this.recipe.name !== '' && 
        this.recipe.short_Description !== '' && 
        this.recipe.number_of_people > 0 && 
        this.recipe.ingredients.length > 0 && 
        this.recipe.preparation_steps.length > 0
      ) {
        return true
      }
      return false
    }
  },
  async mounted () {
    if (this.routeId) {
      try {
        const response = await RecipeService.getRecipeById(this.routeId)
        this.recipe = response.data
        this.mode = 'edit'
      } catch (error) {
        this.showSnackbar({
          text: 'Beim Laden des Rezepts ist leider ein Fehler aufgetreten!',
          color: 'error',
          icon: 'mdi-error'
        })
      }
    }
  },
  methods: {
    ...mapActions({
      showSnackbar: 'snackbar/showSnackbar'
    }),
    addIngredient () {
      if (!this.ingredient.amount && this.ingredient.unit) {
        this.ingredient.unit = null
      }

      this.recipe.ingredients.push(this.ingredient)
      this.ingredient = {
        name: '',
        unit: null,
        amount: null
      }
      this.$refs.form.resetValidation()
    },
    addPreparationStep () {
      this.recipe.preparation_steps.push(this.preparationStep)
      this.preparationStep = {
        short_description: '',
        preparation_time: null,
        cooking_time: null
      }
      this.$refs.form.resetValidation()
    },
    async handleSubmit () {
      this.loading = true
      try {
        if (this.mode === 'add') {
          await RecipeService.saveRecipe(this.recipe)
        } else if (this.mode === 'edit') {
          await RecipeService.updateRecipe(this.routeId, this.recipe)
        }

        this.showSnackbar({
          text: 'Rezept gespeichert!',
          color: 'success',
          icon: 'mdi-info'
        })
        this.$router.push('/')
      } catch (error) {
        this.showSnackbar({
          text: 'Beim Speichern ist leider ein Fehler aufgetreten!',
          color: 'error',
          icon: 'mdi-error'
        })
      } finally {
        this.loading = false
      }
    },
    removeIngredient (index) {
      this.recipe.ingredients.splice(index, 1)
    },
    removePreparationStep (index) {
      this.recipe.preparation_steps.splice(index, 1)
    },
    async ingredientQuerySelections (v) {
      const response = await IngredientService.getIngredientNames()
      this.ingredientItems = response.data
    }
  },
  watch: {
    search (val) {
      val && val !== this.select && this.ingredientQuerySelections(val)
    },
  }
}
</script>

<style scoped lang="scss">

</style>
