<template>
  <v-menu offset-y v-model="menu">
    <template v-slot:activator="{ on, attrs }">
      <v-avatar color="primary" size="36" v-bind="attrs" v-on="on">
        <span class="white-text text-h6" v-text="nameInitials" />
      </v-avatar>
    </template>

    <v-list flat>
      <v-list-item inactive two-line :ripple="false">
        <v-list-item-avatar color="primary">
          <span class="white-text text-h6" v-text="nameInitials" />
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title>
            <b v-text="$auth.user.name" />
          </v-list-item-title>

          <v-list-item-subtitle>
            <p class="ma-0" v-text="$auth.user.email" />
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider />

      <v-hover v-slot:default="{ hover }">
        <v-list-item to="/logout">
          <v-list-item-action>
            <v-icon :class="getMenuTxtClass(hover)" v-text="'mdi-logout'" />
          </v-list-item-action>

          <v-list-item-content>
            <v-list-item-title>
              <span :class="getMenuTxtClass(hover)" v-text="'Logout'" />
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-hover>
    </v-list>
  </v-menu>
</template>

<script>
export default {
  data() {
    return {
      menu: false
    };
  },

  computed: {
    nameInitials() {
      const initials = this.$auth.user.name.split(" ");

      if (initials.length === 2) {
        return `${initials[0].charAt(0)}${initials[1].charAt(0)}`;
      } else if (initials.length === 3) {
        return `${initials[0].charAt(0)}${initials[2].charAt(0)}`;
      } else {
        return initials[0].charAt(0);
      }
    }
  },

  methods: {
    getMenuTxtClass(hover) {
      return hover ? "primary--text" : "grey--text";
    }
  }
};
</script>
