import { axiosClient } from '@/services/Api'

const recipeEndpoint = 'recipe'

export default {

  async getRecipes () {
    const response = await axiosClient.get(recipeEndpoint)
    return response
  },

  async getRecipeById (id) {
    const response = await axiosClient.get(`${recipeEndpoint}/${id}`)
    return response
  },

  async saveRecipe (recipe) {
    const response = await axiosClient.post(recipeEndpoint, recipe)
    return response
  },

  async updateRecipe (id, recipe) {
    const response = await axiosClient.patch(`${recipeEndpoint}/${id}`, recipe)
    return response
  },

  async deleteRecipe (id) {
    const response = await axiosClient.delete(`${recipeEndpoint}/${id}`)
    return response
  }

}
