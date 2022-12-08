<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      max-width="290"
    >
      <v-card>
        <v-card-title class="text-h5">
          Wirklich löschen?
        </v-card-title>

        <v-card-text>
           Diese Aktion kann nicht rückgängig gemacht werden!
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="blue darken-1"
            text
            @click="cancelDelete"
          >
            Abbrechen
          </v-btn>

          <v-btn
            color="blue darken-1"
            text
            @click="confirmDelete"
          >
            Löschen
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  name: 'DeleteDialog',
  props: {
    dialog: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    cancelDelete () {
      this.$emit('cancelDelete')
    },
    confirmDelete () {
      this.$emit('confirmDelete')
    }
  }
}
</script>
