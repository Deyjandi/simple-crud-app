<template>
  <v-row align="center" justify="space-around" class="fill-height">
    <v-card
      v-for="card in cards"
      :key="card.text"
      height="500px"
      width="400px"
      :to="card.to"
    >
      <v-card-text
        class="fill-height flex-column d-flex align-center justify-center"
      >
        <v-icon size="100" v-text="card.icon" />
        <h1 v-text="card.text" />
      </v-card-text>
    </v-card>
  </v-row>
</template>

<script>
export default {
  data() {
    return {
      cards: [
        {
          icon: "mdi-account-group",
          text: "Users",
          to: "/users"
        },
        {
          icon: "mdi-account-group",
          text: "Departments",
          to: "/departments"
        }
      ]
    };
  }
};
</script>
