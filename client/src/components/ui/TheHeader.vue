<template>
  <v-app-bar
      app
      color="primary"
      dark
    >
      <div class="d-flex align-center">
        <v-btn
        href="/"
        text
      >
        Rezept Manager
      </v-btn>
      </div>

      <v-spacer></v-spacer>

      <v-btn
        href="/"
        text
      >
        Rezepte
      </v-btn>

      <v-btn
        href="/ingredients"
        text
      >
        Zutaten
      </v-btn>

      <v-btn
        href="/about"
        text
      >
        <v-icon
          large
          color="white"
        >
          mdi-help
        </v-icon>
      </v-btn>
    </v-app-bar>
</template>

<script>
export default {
  name: 'TheHeader'
}
</script>

<style scoped lang="scss">

</style>
