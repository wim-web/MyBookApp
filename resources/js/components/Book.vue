<template>
  <v-card max-width="200px" class="ma-auto">
    <v-img
            class="white--text"
            max-height="200px"
            :src="book.largeImageUrl"
    >
    </v-img>
    <v-card-text>{{ book.title }}</v-card-text>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on }">
        <v-btn
                class="ma-2" outlined small fab
                color="grey"
                v-on="on"
        >
          <v-icon small>edit</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Edit Book</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field label="title" required v-model="book.title"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="author" required v-model="book.author"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="memo" required v-model="book.memo"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select
                        :items="['未読', '読み中', '完読', '欲しい']"
                        label="status"
                        required
                        v-model="book.status"
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="dialog = false; $emit('updateBook', book)">Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-btn
            class="ma-2" outlined small fab
            color="grey"
            @click="$emit('delete')">
      <v-icon small>delete</v-icon>
    </v-btn>
  </v-card>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        required: true,
      }
    },
    data() {
      return {
        dialog: false,
      }
    },
    created() {
      this.book = Object.assign({}, this.item)
    },
  };
</script>

