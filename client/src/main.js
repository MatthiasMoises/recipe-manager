import Vue from 'vue'
import App from './App.vue'
import router from './router'
import moment from 'moment'
import vuetify from './plugins/vuetify'
import store from './store'

Vue.config.productionTip = false

Vue.filter('getHumanDate', function (date) {
  return moment(date, 'YYYY-MM-DD').format('DD.MM.YYYY')
})

Vue.filter('getHumanDateWithTime', function (dateTime) {
  return moment(dateTime, 'YYYY-MM-DD hh:mm:ss').format('DD.MM.YYYY HH:mm')
})

new Vue({
  router,
  vuetify,
  store,
  render: h => h(App)
}).$mount('#app')
