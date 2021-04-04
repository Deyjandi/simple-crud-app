<template>
  <v-card>
    <v-card-title>
      <v-icon left v-text="'mdi-domain'" />
      <span v-text="'Departments'" />

      <v-btn
        class="ml-4"
        color="primary"
        :disabled="loading"
        text
        outlined
        @click="getItems()"
      >
        <v-icon left v-text="'mdi-refresh'" />
        <span v-text="'Refresh'" />
      </v-btn>

      <v-spacer />

      <v-dialog v-model="newModelDialog" persistent width="550px">
        <template #activator="{on, attrs}">
          <v-btn color="primary" v-bind="attrs" v-on="on">
            <v-icon left v-text="'mdi-plus'" />
            <span v-text="'new department'" />
          </v-btn>
        </template>

        <department-form
          :key="newModelDialog"
          @close="newModelDialog = false"
          @submit="getItems()"
        />
      </v-dialog>
    </v-card-title>

    <v-data-table
      class="elevation-1"
      disable-filtering
      :hide-default-footer="loading"
      fixed-header
      :headers="headers"
      :height="itemsPerPage >= 10 ? 530 : null"
      :items="items"
      :items-per-page="itemsPerPage"
      :loading="loading"
      :server-items-length="totalItems"
      @update:page="currentPage = $event"
      @update:items-per-page="itemsPerPage = $event"
    >
      <template #[`item.departmentIds`]="{ item }">
        <span v-text="getDepartmentIdsText(item.departmentIds)" />
      </template>

      <template #[`item.created_at`]="{ item }">
        <span v-text="formatTimestamp(item.created_at)" />
      </template>

      <template #[`item.updated_at`]="{ item }">
        <span v-text="formatTimestamp(item.updated_at)" />
      </template>

      <template #[`item.actions`]="{ item }">
        <v-menu :nudge-width="200" offset-y light>
          <template #activator="{ on }">
            <v-btn :disabled="loading" icon v-on="on">
              <v-icon v-text="'mdi-dots-vertical'" />
            </v-btn>
          </template>

          <v-list dense>
            <v-list-item>
              <v-list-item-icon>
                <v-icon v-text="'mdi-domain'" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="item.name" />
              </v-list-item-content>
            </v-list-item>

            <v-divider />

            <v-dialog v-model="editModelDialog" persistent width="550px">
              <template #activator="{on, attrs}">
                <v-list-item v-bind="attrs" v-on="on">
                  <v-list-item-icon>
                    <v-icon v-text="'mdi-pencil'" />
                  </v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-title v-text="'Edit'" />
                  </v-list-item-content>
                </v-list-item>
              </template>

              <department-form
                :key="editModelDialog"
                :model="item"
                @close="editModelDialog = false"
                @submit="getItems()"
              />
            </v-dialog>

            <v-list-item @click="deleteItem(item)">
              <v-list-item-icon>
                <v-icon v-text="'mdi-delete'" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="'Delete'" />
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-menu>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
import dates from "@/mixins/dates";
import DepartmentForm from "../components/forms/DepartmentForm";

export default {
  components: { DepartmentForm },
  mixins: [dates],

  data() {
    return {
      // table related
      editModelDialog: false,
      newModelDialog: false,
      currentPage: 1,
      itemsPerPage: 10,
      totalItems: null,
      loading: false,
      items: [],

      // model related
      endpoint: "api/departments",
      headers: [
        {
          text: "ID",
          sortable: true,
          value: "id"
        },
        {
          text: "Name",
          sortable: true,
          value: "name"
        },
        {
          text: "Description",
          sortable: true,
          value: "description"
        },
        {
          text: "Created at",
          sortable: true,
          value: "created_at"
        },
        {
          text: "Updated at",
          sortable: true,
          value: "updated_at"
        },
        {
          text: "Actions",
          sortable: false,
          value: "actions"
        }
      ]
    };
  },

  mounted() {
    this.getItems();
  },

  watch: {
    currentPage() {
      this.getItems();
    },
    itemsPerPage(value) {
      if (value < 0) this.currentPage = 1;

      this.getItems();
    }
  },

  methods: {
    deleteItem(item) {
      this.loading = true;
      this.$axios
        .delete(`${this.endpoint}/${item.id}`)
        .then(() => this.getItems())
        .finally(() => (this.loading = false));
    },
    getDepartmentIdsText(departmentIds) {
      return departmentIds.join(", ");
    },
    getItems() {
      this.loading = true;
      let endpoint = this.endpoint;

      if (this.itemsPerPage > 0) {
        endpoint += `?page=${this.currentPage}&per_page=${this.itemsPerPage}`;
      }

      this.$axios.get(endpoint).then(response => {
        const items = response.data.data || response.data;
        this.items.splice(0);
        this.items.push(...items);

        this.totalItems = response.data.total || this.items.length;

        this.loading = false;
      });
    }
  }
};
</script>
