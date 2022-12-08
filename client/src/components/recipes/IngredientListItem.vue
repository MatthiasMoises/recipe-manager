<template>
  <v-row>
    <v-col cols="1">
      <v-btn
        depressed
        color="primary"
        @click="removeIngredient"
      >
        X
      </v-btn>
    </v-col>
    <v-col>
      {{ singleIngredient.amount }} {{ singleIngredient.unit}} {{ singleIngredient.name }}
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'IngredientListItem',
  props: {
    singleIngredient: {
      type: Object,
      required: true
    },
    ingredientIndex: {
      type: Number,
      required: true
    }
  },
  methods: {
    removeIngredient () {
      this.$emit('ingredientRemoved', this.ingredientIndex)
    }
  }
}
</script>

<style scoped lang="scss">

</style>
