<template>
  <div>
    <h2 class="text-center mb-4">Mypage</h2>
    <Loading v-show="loading"/>
    <div v-show="!loading">
      <div class="row">
        <div v-for="book in myBooks" :key="book.id" class="col-12 col-md-6 col-xl-4">
          <div class="card mb-3">
            <div class="card-body">
              <div class="inline">
                <div class="p-2">
                  <p class="img-wrap">
                    <img :src="book.largeImageUrl">
                  </p>
                </div>
                <div class="p-2 inline__right">
                  <div class="card-title">
                    <a :href="book.itemUrl">{{ book.title }}</a>
                  </div>
                  <select v-model="book.status" v-on:change="updateStatus(book)" class="form-control">
                    <option disabled value></option>
                    <option value="want">買いたい</option>
                    <option value="wait">積んでる</option>
                    <option value="reading">読んでる</option>
                    <option value="finish">読んだよ</option>
                    <option value="ok">理解した</option>
                  </select>
                </div>
              </div>
            </div>
            <button class="btn btn-danger" @click="deleteMyBook(book.id)">
              delete
            </button>
          </div>
        </div>
      </div>
      <div v-show="togglePaginate">
        <paginate 
          :pageCount="pageCount"
          :containerClass="'pagination'"
          :page-class="'page-item'"
          :page-link-class="'page-link'"
          :prev-class="'page-item'"
          :prev-link-class="'page-link'"
          :next-class="'page-item'"
          :next-link-class="'page-link'"
          :clickHandler="fetchMybooksByPage">
        </paginate>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from "../components/Loading";

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

<style lang="scss" scoped>
.inline {
  display: flex;
  &__right {
    width: 100%;
  }
}

.img-wrap {
  width: 150px;
  height: 200px;
  overflow: hidden;
}

.img-wrap img {
  width: 100%;
}

.pagination {
  justify-content: center;
}
</style>
