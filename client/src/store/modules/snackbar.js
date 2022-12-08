import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default {
  namespaced: true,
  state: {
    snackbar: {
      show: false,
      text: '',
      color: '',
      icon: ''
    }
  },
  getters: {
    snackbar: state => state.snackbar
  },
  mutations: {
    showSnackbar (state, { text, color, icon }) {
      state.snackbar = {
        show: true,
        text: text,
        color: color,
        icon: icon
      }
    },
    hideSnackbar (state) {
      state.snackbar = {
        show: false,
        text: '',
        color: '',
        icon: ''
      }
    }
  },
  actions: {
    showSnackbar ({ commit }, payload) {
      commit('showSnackbar', payload)
    },
    hideSnackbar ({ commit }) {
      commit('hideSnackbar')
    }
  }
}
