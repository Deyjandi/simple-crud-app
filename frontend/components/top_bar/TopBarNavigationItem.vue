<template>
  <v-btn nuxt text :to="navigationItem.to">
    <v-icon left v-text="navigationItem.icon" />
    <span v-text="navigationItem.name" />
  </v-btn>
</template>

<script>
export default {
  props: {
    navigationItem: { type: Object, default: () => {} }
  }
};
</script>
