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
      <PieChart />
    </v-card>

    <!--    books-->
    <v-card>
      <v-tabs
              background-color="grey"
              color="deep-purple accent-4"
              :grow=true
      >
        <v-tab
                v-for="item in statuses"
                class="ma-0"
                @click="status = item">{{ item }}
        </v-tab>
      </v-tabs>
      <v-row>
        <v-col
                v-for="book in this.filteredBooks"
                :key="book.id"
        >

          <Book
                  :item="book"
                  @delete="deleteBook(book.id)"
                  @updateBook="updateBook"
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
  import PieChart from "../components/PieChart";

  export default {
    data() {
      return {
        books: [],
        loading: false,
        statuses: ['すべて', '未読', '読み中', '完読', '欲しい'],
        status: 'すべて',
      };
    },
    components: {
      PieChart,
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
      updateBook: async function (book) {
        const response = await axios.patch(`/books/${book.id}`, book)
            .catch(err => err);
        if (response.status !== 200) return alert('error');
        this.fetchMyBooks();
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
        if (this.status === 'すべて') return this.books;
        return this.books.filter(function ($r) {
          if ($r.status === this.status) return $r;
        }, this);
      }
    },
    created() {
      this.fetchMyBooks();
    },
  };
</script>

