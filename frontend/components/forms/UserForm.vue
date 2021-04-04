<template>
  <base-form
    :model-id="modelId"
    :payload="payload"
    :disable-submit="disableSubmit"
    @close="$emit('close')"
    @error="setErrors($event)"
    @submit="$emit('submit', $event), $emit('close')"
  >
    <template #title>
      <v-icon left v-text="title.icon" />
      <span v-text="title.text" />
    </template>

    <template #fields>
      <v-text-field
        v-model="payload.data.name"
        class="my-2"
        :error-messages="errors.name"
        label="Name"
        prepend-icon="mdi-form-textbox"
      />

      <v-text-field
        v-model="payload.data.email"
        class="my-2"
        :error-messages="errors.email"
        label="Email"
        prepend-icon="mdi-email"
      />

      <v-text-field
        v-model="payload.data.password"
        class="my-2"
        :error-messages="errors.password"
        counter
        hint="Between 8 and 32 characters"
        label="Password"
        prepend-icon="mdi-lock"
        type="password"
      />

      <v-autocomplete
        v-model="payload.data.departments"
        class="my-2"
        :error-messages="errors.departments"
        clearable
        small-chips
        item-text="name"
        item-value="id"
        :items="departments"
        label="Assign to departments"
        :loading="loading"
        multiple
        prepend-icon="mdi-domain"
      />
    </template>
  </base-form>
</template>

<script>
import BaseForm from "./BaseForm";

export default {
  components: { BaseForm },

  props: {
    model: { type: Object, default: () => {} }
  },

  data() {
    return {
      loading: false,
      errors: {
        name: [],
        email: [],
        password: [],
        departments: []
      },

      departments: [],

      payload: {
        endpoint: "/api/users",
        data: {
          name: "",
          email: "",
          password: "",
          departments: []
        }
      }
    };
  },

  computed: {
    disableSubmit() {
      return !this.payload.data.name || !this.payload.data.email;
    },
    modelId() {
      return this.$props.model ? this.$props.model.id : null;
    },
    title() {
      return {
        icon: this.modelId ? "mdi-account-edit" : "mdi-account-plus",
        text: this.modelId ? `Edit: ${this.$props.model.name}` : "New user"
      };
    }
  },

  mounted() {
    this.getDepartments();

    if (this.modelId) {
      this.payload.data = { ...this.payload.data, ...this.$props.model };

      this.payload.data.departments.push(
        ...(this.$props.model.departmentIds ?? [])
      );
    }
  },

  methods: {
    getDepartments() {
      this.loading = true;
      this.$axios
        .get("api/departments")
        .then(response => this.departments.push(...response.data))
        .finally(() => {
          this.loading = false;
        });
    },

    setErrors(errors) {
      this.$set(this, "errors", errors);
    }
  }
};
</script>
