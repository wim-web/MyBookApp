<template>
  <div>
    <h2 class="text-center mb-4">Mypage</h2>

    <!--    user info-->
    <v-card
            max-width="1000"
            class="mx-auto mb-10"
            height="300"
    >
      <div>
        <v-avatar color="grey" size=70>
          <img src="https://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar">
        </v-avatar>
      </div>
      <p>name</p>
      <p>url</p>
    </v-card>

    <!--    books-->
    <v-card>
      <v-tabs
              background-color="grey"
              color="deep-purple accent-4"
              :grow=true
      >
        <v-tab
                v-for="(value, key) in statuses"
                :key="key"
                class="ma-0"
                @click="status = key">{{ value }}
        </v-tab>
      </v-tabs>
      <v-row>
        <v-col
                v-for="book in this.filteredBooks"
                :key="book.id"
        >

          <Book
                  :book="book"
                  @delete="deleteBook(book.id)"
          />

        </v-col>
      </v-row>
    </v-card>

    <!--    tag-->
    <v-chip
            class="ma-2"
            color="pink"
            label
            text-color="white"
    >
      <v-icon left>label</v-icon>
      PHP
    </v-chip>
    <v-chip
            class="ma-2"
            color="pink"
            label
            text-color="white"
    >
      <v-icon left>label</v-icon>
      Java
    </v-chip>
  </div>
</template>

<script>
  import Loading from "../components/Loading";
  import Book from "../components/Book";

  export default {
    data() {
      return {
        books: [],
        loading: false,
        statuses: {all: 'すべて', wait: '未読', reading: '読み中', finish: '完読', want: '欲しい'},
        status: 'all',
      };
    },
    components: {
      Book,
      Loading
    },
    methods: {
      async fetchMyBooks() {
        //todo: error handling
        this.loading = true;

        const response = await axios.get(`/books?page=${this.page}`).catch(err => err.response);
        if (response.status === 200) {
          this.books = response.data.data;
        } else {
          alert('error');
        }

        this.loading = false;
      },
      async updateStatus(selectedBook) {
        //todo:error handling
        const statusObj = {status: selectedBook.status};
        const response = await axios.patch(`/books/${selectedBook.id}/status`, statusObj)
            .catch(err => err);
        if (response.status !== 200) return alert('error');
      },
      async deleteBook(id) {
        const deleteFlg = confirm("delete?");
        if (!deleteFlg) return;

        const response = await axios.delete(`/books/${id}`).catch(err => err.response);
        if (response.status === 200) {
          this.fetchMyBooks();
        } else {
          alert('error');
        }
      },
    },
    computed: {
      filteredBooks: function () {
        if (this.status === 'all') return this.books;
        return this.books.filter(function ($r) {
          if ($r.status === this.status) return $r;
        }, this);
      }
    },
    watch: {

    },
    created() {
      this.fetchMyBooks();
    },
  };
</script>

