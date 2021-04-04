export default {
  methods: {
    formatTimestamp(timestamp) {
      return this.$moment(new Date(timestamp)).format("LLLL");
    }
  }
};
