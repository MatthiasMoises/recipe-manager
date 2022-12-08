<template>
  <v-row>
    <v-col cols="1">
      <v-btn
        depressed
        color="primary"
        @click="removePreparationStep"
      >
        X
      </v-btn>
    </v-col>
    <v-col>
      <v-row>
        <v-col>
          <span class="step-title">
            {{ stepIndex + 1 }}. Schritt
          </span>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          {{ singleStep.short_description }}
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'PreparationStepListItem',
  props: {
    singleStep: {
      type: Object,
      required: true
    },
    stepIndex: {
      type: Number,
      required: true
    }
  },
  methods: {
    removePreparationStep () {
      this.$emit('preparationStepRemoved', this.stepIndex)
    }
  }
}
</script>

<style scoped lang="scss">

.step-title {
  font-size: 18px;
  font-weight: bold;
}

</style>
