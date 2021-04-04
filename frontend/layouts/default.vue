<template>
  <v-app dark>
    <top-bar v-if="loggedIn" />

    <v-main>
      <v-container :fill-height="fillHeight" fluid>
        <nuxt />
      </v-container>
    </v-main>

    <v-footer color="grey darken-4" fixed max-height="48px" v-if="loggedIn">
      <span
        class="v-subheader grey--text"
        v-html="`&copy; ${new Date().getFullYear()} - ${author.name}`"
      />
    </v-footer>
  </v-app>
</template>

<script>
import { mapState } from "vuex";
import TopBar from "../components/top_bar/TopBar";

export default {
  components: { TopBar },

  computed: {
    ...mapState(["author"]),

    fillHeight() {
      switch (this.$route.path) {
        case "/":
        case "/login":
        case "/logout":
          return true;
        default:
          return false;
      }
    },
    loggedIn() {
      return this.$auth.loggedIn;
    }
  }
};
</script>

<style>
.page-enter-active,
.page-leave-active {
  transition: opacity 0.4s;
}
.page-enter,
.page-leave-to {
  opacity: 0;
}

html {
  overflow-y: hidden;
}

a {
  color: #1976d2;
  text-decoration: none;
}
</style>
