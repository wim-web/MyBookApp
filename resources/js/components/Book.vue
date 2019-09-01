<template>
  <v-card max-width="200px" class="ma-auto">
    <v-img
            class="white--text"
            max-height="200px"
            :src="item.largeImageUrl"
    >
    </v-img>
    <v-card-text class="text-hidden">{{ item.title }}</v-card-text>
    <Dialog :role="role" :item="item"
    @createBook="notifyCreate"
    @updateBook="notifyUpdate"
    />
    <v-btn
            v-if="destroy"
            class="ma-2" outlined small fab
            color="grey"
            @click="$emit('delete')">
      <v-icon small>delete</v-icon>
    </v-btn>
  </v-card>
</template>

<script>
  import Dialog from "./Dialog";
  export default {
    props: {
      item: {
        type: Object,
        required: true,
      },
      role: {
        type: String,
        required: true,
      },
      destroy: false,
    },
    components: {
      Dialog,
    },
    methods: {
      notifyCreate: function (book) {
        return this.$emit('createBook', book);
      },
      notifyUpdate: function (book) {
        return this.$emit('updateBook', book);
      }
    },
  };
</script>

<style lang="scss" scoped>
  .text-hidden {
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }

</style>

