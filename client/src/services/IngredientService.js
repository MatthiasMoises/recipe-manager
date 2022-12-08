import { axiosClient } from '@/services/Api'

const ingredientEndpoint = 'ingredient'

export default {

  async getIngredientNames () {
    const response = await axiosClient.get(`${ingredientEndpoint}/names`)
    return response
  },

  async getIngredients () {
    const response = await axiosClient.get(ingredientEndpoint)
    return response
  },

  async getIngredientById (id) {
    const response = await axiosClient.get(`${ingredientEndpoint}/${id}`)
    return response
  },

  async saveIngredient (ingredient) {
    const response = await axiosClient.post(ingredientEndpoint, ingredient)
    return response
  },

  async updateIngredient (id, ingredient) {
    const response = await axiosClient.put(`${ingredientEndpoint}/${id}`, ingredient)
    return response
  },

  async deleteIngredient (id) {
    const response = await axiosClient.delete(`${ingredientEndpoint}/${id}`)
    return response
  }
}
