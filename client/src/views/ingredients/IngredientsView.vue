<template>
  <v-container>
    <v-data-table
      :headers="headers"
      :items="ingredients"
      sort-by="calories"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>Alle Zutaten</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>
          <v-dialog
            v-model="dialog"
            max-width="500px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="primary"
                dark
                class="mb-2"
                v-bind="attrs"
                v-on="on"
              >
                Neue Zutat
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-form ref="form">
                  <v-container>
                    <v-row>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          v-model="editedItem.name"
                          label="Name"
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          type="number"
                          v-model="editedItem.cup_in_grams"
                          label="Tasse in Gramm"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          type="number"
                          v-model="editedItem.level_tablespoon_in_grams"
                          label="Esslöffel (gestrichen) in Gramm"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          type="number"
                          v-model="editedItem.heaped_tablespoon_in_grams"
                          label="Esslöffel (gehäuft) in Gramm"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          type="number"
                          v-model="editedItem.level_teaspoon_in_grams"
                          label="Teelöffel (gestrichen) in Gramm"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-form>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="close"
                >
                  Abbrechen
                </v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  :disabled="!formValid"
                  @click="save"
                >
                  Speichern
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5">Möchten Sie diese Zutat wirklich löschen?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete">Abbrechen</v-btn>
                <v-btn color="blue darken-1" text @click="deleteIngredientConfirm">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon
          small
          class="mr-2"
          @click="editIngredient(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
          small
          @click="deleteIngredient(item)"
        >
          mdi-delete
        </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn
          color="primary"
          @click="initialize"
        >
          Zurücksetzen
        </v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import IngredientService from '@/services/IngredientService'
import { mapActions } from 'vuex'
import { validationRules } from '@/helpers/ValidationRules'

export default {
  name: 'IngredientsView',
  data () {
    return {
      valid: false,
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'ID',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'Name', value: 'name' },
        { text: 'Tasse in Gramm', value: 'cup_in_grams' },
        { text: 'Esslöffel (getrichen) in Gramm', value: 'level_tablespoon_in_grams' },
        { text: 'Esslöffel (gehäuft) in Gramm', value: 'heaped_tablespoon_in_grams' },
        { text: 'Teelöffel (getrichen) in Gramm', value: 'level_teaspoon_in_grams' },
        { text: 'Aktionen', value: 'actions', sortable: false },
      ],
      ingredients: [],
      editedIndex: -1,
      editedItem: {
        id: 0,
        name: '',
        cup_in_grams: 0,
        level_tablespoon_in_grams: 0,
        heaped_tablespoon_in_grams: 0,
        level_teaspoon_in_grams: 0,
      },
      defaultItem: {
        id: 0,
        name: '',
        cup_in_grams: 0,
        level_tablespoon_in_grams: 0,
        heaped_tablespoon_in_grams: 0,
        level_teaspoon_in_grams: 0,
      },
      rules: { ...validationRules }
    }
  },
  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'Neue Zutat' : 'Zutat bearbeiten'
    },
    formValid () {
      return this.editedItem.name ? true : false
    }
  },
  watch: {
    dialog (val) {
      val || this.close()
    },
    dialogDelete (val) {
      val || this.closeDelete()
    },
  },
  created () {
    this.initialize()
  },
  methods: {
    ...mapActions({
      showSnackbar: 'snackbar/showSnackbar'
    }),
    async initialize () {
      try {
        const response = await IngredientService.getIngredients()
        this.ingredients = response.data
      } catch (error) {
        this.showSnackbar({
          text: 'Beim Abrufen der Zutaten ist leider ein Fehler aufgetreten!',
          color: 'error',
          icon: 'mdi-error'
        })
      }
    },
    editIngredient (item) {
      this.editedIndex = this.ingredients.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteIngredient (item) {
      this.editedIndex = this.ingredients.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    async deleteIngredientConfirm () {
      this.ingredients.splice(this.editedIndex, 1)

      try {
        await IngredientService.deleteIngredient(this.editedItem.id)
      } catch (error) {
        this.showSnackbar({
          text: 'Beim Löschen der Zutat ist leider ein Fehler aufgetreten!',
          color: 'error',
          icon: 'mdi-error'
        })
      }

      this.closeDelete()
    },

    close () {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
      this.resetFormValidation()
    },

    closeDelete () {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    async save () {
      if (this.editedIndex > -1) {
        try {
          const response = await IngredientService.updateIngredient(this.editedItem.id, this.editedItem)
          Object.assign(this.ingredients[this.editedIndex], response.data)
        } catch (error) {
          this.showSnackbar({
            text: 'Beim Aktualisieren der Zutat ist leider ein Fehler aufgetreten!',
            color: 'error',
            icon: 'mdi-error'
          })
        }
      } else {
        try {
          const response = await IngredientService.saveIngredient(this.editedItem)
          this.ingredients.push(response.data)
        } catch (error) {
          this.showSnackbar({
            text: 'Beim Speichern der Zutat ist leider ein Fehler aufgetreten!',
            color: 'error',
            icon: 'mdi-error'
          })
        }
      }
      this.close()
    },
    resetFormValidation () {
      this.$refs.form.resetValidation()
    }
  }
}
</script>

<style scoped lang="scss">

</style>
