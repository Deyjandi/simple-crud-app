<template>
  <v-card>
    <v-form @submit.prevent="submit()">
      <v-card-title>
        <slot name="title">
          <h1 v-text="'TITLE SLOT'" />
        </slot>

        <v-spacer />

        <v-btn color="red" :disabled="loading" icon @click="$emit('close')">
          <v-icon v-text="'mdi-close'" />
        </v-btn>
      </v-card-title>

      <v-card-text>
        <slot name="fields">
          <h1 v-text="'FORM FIELDS SLOT'" />
        </slot>
      </v-card-text>

      <v-card-actions>
        <v-spacer />

        <v-btn color="red" :disabled="loading" text @click="$emit('close')">
          <span v-text="'cancel'" />
        </v-btn>

        <v-btn
          color="primary"
          :disabled="disableSubmit"
          :loading="loading"
          type="submit"
        >
          <span v-text="'submit'" />
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script>
export default {
  props: {
    modelId: { type: Number, default: null },
    disableSubmit: { type: Boolean, default: false },
    payload: { type: Object, default: () => {} }
  },

  data() {
    return {
      loading: false
    };
  },

  computed: {
    data() {
      return this.$props.payload.data;
    },
    endpoint() {
      let endpoint = this.$props.payload.endpoint;
      return (endpoint += this.$props.modelId ? `/${this.$props.modelId}` : "");
    },
    method() {
      return this.$props.modelId ? "patch" : "post";
    }
  },

  methods: {
    submit() {
      this.$emit("error", {});
      this.loading = true;

      switch (this.method) {
        case "patch":
          this.$axios
            .patch(this.endpoint, this.data)
            .then(response => this.$emit("submit", response))
            .catch(error => {
              this.$emit("error", error.errors);
            })
            .finally(() => (this.loading = false));
          break;

        case "post":
          this.$axios
            .post(this.endpoint, this.data)
            .then(response => this.$emit("submit", response))
            .catch(error => {
              this.$emit("error", error.errors);
            })
            .finally(() => (this.loading = false));
          break;
      }
    }
  }
};
</script>
