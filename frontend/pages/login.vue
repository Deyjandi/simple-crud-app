<template>
  <v-row align="center" justify="center">
    <v-col class="text-center" :cols="12" :sm="8" :md="4" :lg="3">
      <v-form @submit.prevent="login()">
        <v-scale-transition>
          <v-card :elevation="12" color="transparent" v-show="show">
            <logo src="/pk-white.png" />
            <v-card-text>
              <v-text-field
                :disabled="loading"
                :label="'Email'"
                prepend-inner-icon="mdi-account"
                single-line
                v-model="data.email"
              />

              <v-text-field
                :append-icon="showPwd ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPwd = !showPwd"
                :disabled="loading"
                :label="'Password'"
                prepend-inner-icon="mdi-lock"
                single-line
                :type="showPwd ? 'text' : 'password'"
                v-model="data.password"
              />
            </v-card-text>

            <v-card-actions class="justify-center">
              <v-btn
                color="primary"
                :disabled="loading || !data.email || !data.password"
                :loading="loading"
                type="submit"
              >
                <span v-text="'login'" />
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-scale-transition>
      </v-form>
    </v-col>
  </v-row>
</template>

<script>
export default {
  auth: "guest",

  data() {
    return {
      show: false,
      data: {
        email: "",
        password: ""
      },
      loading: false,
      showPwd: false
    };
  },

  mounted() {
    if (this.$auth.loggedIn) this.$router.replace("/");
    else this.show = true;
  },

  methods: {
    login() {
      this.loading = true;

      this.$axios.get("/sanctum/csrf-cookie").then(() => {
        this.$auth
          .loginWith("local", {
            data: this.data
          })
          .then(() => {
            this.show = false;
            this.$router.replace("/");
          })
          .catch(error => {
            // error toaster
          })
          .finally(() => {
            this.loading = false;
          });
      });
    }
  }
};
</script>
