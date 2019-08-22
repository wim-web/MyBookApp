<template>
  <div>
    <h2 class="text-center mb-4">Mypage</h2>

    <!--    user info-->
    <v-card
            max-width="1000"
            class="mx-auto"
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

        <v-tab class="ma-0" @click="filterByStatus('all')">all</v-tab>
        <v-tab @click="filterByStatus('wait')">未読</v-tab>
        <v-tab @click="filterByStatus('reading')">読み中</v-tab>
        <v-tab @click="filterByStatus('finish')">完読</v-tab>
        <v-tab @click="filterByStatus('want')">欲しい</v-tab>

      </v-tabs>
      <v-row>
        <v-col
                v-for="book in this.books"
                :key="book.id"
                cols="4"
                md="6"
        >

          <Book :book="book"/>

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
        myBooks: [],
        books: [],
        loading: false,
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
          const booksArray = response.data.data;
          this.setTogglePaginate(booksArray.length);

          this.myBooks = booksArray;
          this.books = this.myBooks;
          this.pageCount = response.data.last_page;
        } else {
          alert('error');
        }

        this.loading = false;
      },
      async deleteMyBook(id) {
        const deleteFlg = confirm("delete?");
        if (!deleteFlg) return;

        const response = await axios.delete(`/books/${id}`).catch(err => err.response);
        if (response.status === 200) {
          this.fetchMyBooks();
        } else {
          alert('error');
        }
      },
      async updateStatus(selectedBook) {
        //todo:error handling
        const statusObj = {status: selectedBook.status};
        const response = await axios.patch(`/books/${selectedBook.id}/status`, statusObj)
            .catch(err => err);
        if (response.status !== 200) return alert('error');
      },
      fetchMybooksByPage(page) {
        this.page = page;
        this.fetchMyBooks();
      },
      setTogglePaginate(length) {
        if (length > 0) {
          this.togglePaginate = true;
        } else {
          this.togglePaginate = false;
        }
      },
      filterByStatus(status) {
        if (status === 'all') return this.books = this.myBooks;
        this.books = this.myBooks.filter(function ($r) {
          if ($r.status === status) return $r
        });
      }
    },
    created() {
      this.fetchMyBooks();
    },
  };
</script>

