<template>
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
            </div>
          </div>
        </div>
        <button class="btn btn-outline-primary" @click="addBookMylist(book)">
          mybookに追加
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    books: {
      type: Array,
      required: true
    }
  },
  methods: {
    async addBookMylist(bookData) {
      //todo:error handling
      const response = await axios.post(`/books`, bookData).catch(err => err.response);
      if (response.status === 201) {
        alert('success');
      } else {
        alert('error');
      }

    }
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
</style>
