<template>
  <v-app>
    <TheHeader />
    <v-main>
      <router-view/>
    </v-main>
    <TheFooter />
    <InfoSnackbar />
  </v-app>
</template>

<script>
import TheHeader from '@/components/ui/TheHeader.vue'
import TheFooter from '@/components/ui/TheFooter.vue'
import InfoSnackbar from '@/components/helpers/InfoSnackbar.vue'

export default {
  name: 'App',
  components: {
    TheHeader,
    TheFooter,
    InfoSnackbar
  }
}
</script>
