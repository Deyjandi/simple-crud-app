<template>
  <v-app-bar app color="grey darken-4" dense fixed>
    <v-toolbar-title>
      <nuxt-link class="white--text" to="/" v-text="name" />
    </v-toolbar-title>

    <v-spacer />

    <top-bar-navigation-item
      v-for="item in navigationItems"
      :key="item.to"
      :navigation-item="item"
    />

    <v-spacer />

    <top-bar-avatar-menu />
  </v-app-bar>
</template>

<script>
import { mapState } from "vuex";
import TopBarAvatarMenu from "./TopBarAvatarMenu";
import TopBarNavigationItem from "./TopBarNavigationItem";

export default {
  components: { TopBarAvatarMenu, TopBarNavigationItem },

  data() {
    return {
      navigationItems: [
        {
          name: "Users",
          icon: "mdi-account-group",
          to: "/users"
        },
        {
          name: "Departments",
          icon: "mdi-domain",
          to: "/departments"
        }
      ]
    };
  },

  computed: {
    ...mapState(["name"])
  }
};
</script>
