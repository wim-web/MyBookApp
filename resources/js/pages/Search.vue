<template>
  <div>
    <h2 class="text-center mb-4">Add Book</h2>
    <form @submit.prevent="fetchBooksData()">
      <div class="input-group mb-3 form">
        <input v-model="inputTitle"
               class="form-control"
               type="text"
               placeholder="タイトルで検索"
               required>
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">
            search
          </button>
        </div>
      </div>
    </form>
    <p v-show="showSearchResultCount">検索結果:{{ searchResultCount }}</p>
    <Loading v-if="loading"/>
    <Book v-else :books="books"/>
  </div>
</template>

<script>
import Book from "../components/Book";
import Loading from "../components/Loading";

export default {
  data() {
    return {
      inputTitle: "",
      inputAuthor: "",
      books: [],
      searchResultCount: -1,
      loading: false
    };
  },
  components: {
    Book,
    Loading
  },
  computed: {
    showSearchResultCount() {
      return this.searchResultCount >= 0;
    }
  },
  methods: {
    fetchBooksData() {
      
      const params = this.setParams(this.inputTitle);

      this.loading = true;
      //axiosだとcorsに引っかかるので、ここだけajax
      $.ajax(params)
        .done(data => {
          this.books = data.Items;
          this.searchResultCount = data.count;
        })
        .fail(data => {
          //todo:error handling
          alert('error');
        })
        .always(() => {
          this.loading = false;
        });
    },
    setParams(inputTitle) {
      return {
        url: "https://app.rakuten.co.jp/services/api/BooksTotal/Search/20170404",
        type: "GET",
        datatype: "json",
        data: {
          applicationId: "1019399324990976605",
          keyword: inputTitle,
          formatVersion: 2,
          elements:
            "count,page,hits,pageCount,title,author,itemCaption,itemUrl,largeImageUrl"
        }
      };
    }
  },
  beforeCreate() {
    this.$store.commit("showMenu");
  }
};
</script>

<style lang="scss" scoped>
.form {
  max-width: 500px;
  margin: 0 auto;
}
</style>

