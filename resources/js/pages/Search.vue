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
    <Loading v-show="loading"/>
    <div v-show="searchResultCount > 0 && !loading">
      <v-card>
        <v-container>
          <v-row>
            <v-col
                    v-for="book in books"
                    :key="book.id"
                    cols="6"
                    sm="4"
                    lg="3"
            >

              <Book
                      :item="book"
              />

            </v-col>
          </v-row>
          <paginate
                  :pageCount="pageCount"
                  :containerClass="'pagination'"
                  :page-class="'page-item'"
                  :page-link-class="'page-link'"
                  :prev-class="'page-item'"
                  :prev-link-class="'page-link'"
                  :next-class="'page-item'"
                  :next-link-class="'page-link'"
                  :clickHandler="fetchBooksDataByPage">
          </paginate>
        </v-container>
      </v-card>
    </div>
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
      page: '',
      pageCount: 0,
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
    fetchBooksData(page = 1) {
      
      const params = this.setParams(this.inputTitle, page);

      this.loading = true;
      //axiosだとcorsに引っかかるので、ここだけajax
      $.ajax(params)
        .done(data => {
          if (data.Items) this.books = data.Items;
          this.searchResultCount = data.count;
          this.pageCount = data.pageCount;
        })
        .fail(data => {
          //todo:error handling
          alert('error');
        })
        .always(() => {
          this.loading = false;
        });
    },
    setParams(inputTitle, page) {
      return {
        url: "https://app.rakuten.co.jp/services/api/BooksTotal/Search/20170404",
        type: "GET",
        datatype: "json",
        data: {
          applicationId: "1019399324990976605",
          keyword: inputTitle,
          page: page,
          hits: 12,
          formatVersion: 2,
          elements:
            "count,page,hits,pageCount,title,author,itemCaption,itemUrl,largeImageUrl"
        }
      };
    },
    fetchBooksDataByPage(page) {
      this.fetchBooksData(page);
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

.pagination {
  justify-content: center;
}
</style>


