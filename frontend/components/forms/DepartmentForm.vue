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

      <v-textarea
        v-model="payload.data.description"
        class="my-2"
        :auto-grow="false"
        :error-messages="errors.description"
        label="Description"
        no-resize
        prepend-icon="mdi-text"
        :rows="4"
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
        description: []
      },

      payload: {
        endpoint: "/api/departments",
        data: {
          name: "",
          description: ""
        }
      }
    };
  },

  computed: {
    disableSubmit() {
      return !this.payload.data.name || !this.payload.data.description;
    },
    modelId() {
      return this.$props.model ? this.$props.model.id : null;
    },
    title() {
      return {
        icon: this.modelId ? "mdi-pencil" : "mdi-domain-plus",
        text: this.modelId
          ? `Edit: ${this.$props.model.name}`
          : "New department"
      };
    }
  },

  mounted() {
    if (this.modelId) {
      this.payload.data = { ...this.payload.data, ...this.$props.model };
    }
  },

  methods: {
    setErrors(errors) {
      this.$set(this, "errors", errors);
    }
  }
};
</script>
