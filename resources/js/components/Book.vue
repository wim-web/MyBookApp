<template>
  <v-card max-width="200px" >
    <v-img
            class="white--text"
            height="200px"
            :src="book.itemUrl"
    >
    </v-img>
    <v-card-text>{{ book.title }}</v-card-text>
    <v-btn class="ma-2" outlined large fab color="indigo">
      <v-icon>edit</v-icon>
    </v-btn>
    <v-btn
            class="ma-2" outlined large fab
            color="indigo"
            @click="$emit('delete')">
      <v-icon>remove</v-icon>
    </v-btn>
  </v-card>
</template>

<script>
export default {
  props: {
    book: {
      type: Object,
      required: true
    }
  },
};
</script>

