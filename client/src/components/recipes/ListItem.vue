<template>
  <div class="recipe-list-item">
    <router-link :to="{ path: `view-recipe/${recipe.id}` }">
      <v-row>
        <v-col cols="3">
          <img :src="require('@/assets/default-placeholder.png')" width="150" height="150" alt="placeholder" />
        </v-col>
        <v-col cols="6">
          <v-row>
            <v-col>
              <span class="recipe-title">
                {{ recipe.name }}
              </span>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <span v-if="(recipe && recipe.short_description)">
                {{ recipe.short_description }}
              </span>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="3">
          <v-row >
            <v-col class="text-right">
              Erstellt am
            </v-col>
          </v-row>
          <v-row>
            <v-col class="text-right">
              {{ recipe.created_at | getHumanDateWithTime }}
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'ListItem',
  props: {
    recipe: {
      type: Object,
      required: true
    }
  }
}
</script>

<style scoped lang="scss">

.recipe-list-item {
  border: 1px solid lightgray;
  border-radius: 5px;
  padding: 20px;
  margin-bottom: 15px;
  
  a {
    text-decoration: none;
    color: black;
  }
}

.recipe-title {
  font-size: 22px;
  font-weight: bold;
}

</style>
