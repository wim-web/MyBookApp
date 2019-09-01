<template>
  <v-dialog v-model="dialog" persistent max-width="600px">
    <template v-slot:activator="{ on }">
      <v-btn  v-if="role === 'add' || role === 'edit'"
              class="ma-2" outlined small fab
              color="grey"
              v-on="on"
      >
        <v-icon small>{{ role }}</v-icon>
      </v-btn>
      <v-btn v-else-if="role === 'customAdd'" v-on="on">
        <v-icon left>menu_book</v-icon>
        Custom Add
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="headline">{{ role }} Book</span>
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
        <v-btn color="blue darken-1" text @click="dialog = false; $emit(createOrUpdate, book)">Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        required: true,
      },
      role: {
        type: String,
        required: true,
      }
    },
    data() {
      return {
        book: {},
        dialog: false,
      }
    },
    computed: {
      createOrUpdate: function () {
        if (this.role === 'edit') return 'updateBook';
        return 'createBook';
      }
    },
    created() {
      this.book = Object.assign({}, this.item)
    },
  }
</script>