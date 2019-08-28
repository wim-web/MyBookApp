<template>
  <div>
    <h2 class="text-center mb-4">Public page</h2>
    <Loading v-show="loading"/>
    <div v-show="!loading">
      <div class="row">
        <div v-for="book in books" :key="book.id" class="col-12 col-md-6 col-xl-4">
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
                  <select v-model="book.status" class="form-control" disabled>
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
          :clickHandler="fetchBooksByPage">
        </paginate>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from '../components/Loading';
export default {
  props: {
    name: {
      type: String,
      required: true,
    }
  },
  data() {
    return {
      books: [],
      loading: false,
      pageCount: 0,
      togglePaginate: false,
      page: 1,
    }
  },
  components: {
    Loading,
  },
  methods: {
    async fetchBooksByUser() {
      this.loading = true;
      const response = await axios.get(`/${this.name}/?page=${this.page}`);
      console.log(response)
      if (response.status === 200) {
        const booksArray = response.data.data;
        this.setTogglePaginate(booksArray.length);
        this.books = booksArray;
        this.pageCount = response.data.last_page;
      } else {
        alert('error');
      }
      this.loading = false;
    },
    fetchBooksByPage(page) {
      this.page = page;
      this.fetchBooksByUser();
    },
    setTogglePaginate(length) {
      if (length > 0) {
        this.togglePaginate = true;
      } else {
        this.togglePaginate = false;
      }
    },
  },
  created() {
    this.fetchBooksByUser();
  },
}
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
