<template>
  <div>
    <h2 class="text-center mb-4">Mypage</h2>
<!--    vuefity-->

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
        
        <v-tab>all</v-tab>
        <v-tab>未読</v-tab>
        <v-tab>完読</v-tab>
        <v-tab>読書</v-tab>
      
        
        
      </v-tabs>
      <v-row>
      <v-col
              v-for="book in this.myBooks"
              :key="book.id"
              cols="4"
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
    </v-chip><v-chip
            class="ma-2"
            color="pink"
            label
            text-color="white"
    >
      <v-icon left>label</v-icon>
      Java
    </v-chip>
    
<!--    vuefity-->
  </div>
</template>

<script>
import Loading from "../components/Loading";
import Book from "../components/Book";

export default {
  data() {
    return {
      myBooks: [],
      status: {},
      pageCount: 0,
      page: 1,
      loading: false,
      togglePaginate: false,
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
      const statusObj = { status: selectedBook.status };
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
    }
  },
  created() {
    this.fetchMyBooks();
  },
  beforeCreate() {
    this.$store.commit("showMenu");
  }
};
</script>

