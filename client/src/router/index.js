import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/add-recipe',
    name: 'add-recipe',
    component: () => import(/* webpackChunkName: "add-recipe" */ '../views/recipes/EditRecipe.vue')
  },
  {
    path: '/edit-recipe/:id',
    name: 'edit-recipe',
    component: () => import(/* webpackChunkName: "edit-recipe" */ '../views/recipes/EditRecipe.vue')
  },
  {
    path: '/view-recipe/:id',
    name: 'view-recipe',
    component: () => import(/* webpackChunkName: "add-recipe" */ '../views/recipes/ViewRecipe.vue')
  },
  {
    path: '/ingredients',
    name: 'ingredients',
    component: () => import(/* webpackChunkName: "ingredients" */ '../views/ingredients/IngredientsView.vue')
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
