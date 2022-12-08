<template>
  <v-snackbar
    v-if="snackbar.show"
    :value="snackbar"
    :bottom="snackbarY"
    :timeout="snackbarTimeout"
    :color="snackbar.color"
  >
    <div style="text-align: center;">
      <v-icon color="white">{{ snackbar.icon }}</v-icon>&nbsp;<span class="snackbar-text">{{ snackbar.text }}</span>
      <br>
      <v-btn
        text
        color="white"
        @click="hideSnackbar"
      >
        <v-icon small title="Schließen">mdi-close</v-icon>
      </v-btn>
    </div>
  </v-snackbar>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'InfoSnackbar',
  data () {
    return {
      snackbarY: 'bottom',
      snackbarTimeout: 5000
    }
  },
  computed: {
    ...mapGetters({
      snackbar: 'snackbar/snackbar'
    })
  },
  methods: {
    ...mapActions({
      hideSnackbar: 'snackbar/hideSnackbar'
    })
  }
}
</script>

<style scoped lang="scss">

.snackbar-text {
  font-size: 18px;
}

</style>
