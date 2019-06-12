<template>
    <div>
        <h2 class="text-center mb-4">Mypage</h2>
        <Loading v-if="loading"/>
        <div v-else class="row">
            <div v-for="book in myBooks" :key="book.id" class="col-12 col-md-6 col-xl-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="inline">
                            <div class="p-2">
                                <p class="img-wrap"><img :src="book.largeImageUrl"></p>
                            </div>
                            <div class="p-2 inline__right">
                                <div class="card-title"><a :href="book.itemUrl">{{ book.title }}</a></div>
                                <select v-model="book.status" v-on:change="updateStatus(book)" class="form-control">
                                    <option disabled value=""></option>
                                    <option value="want">買いたい</option>
                                    <option value="wait">積んでる</option>
                                    <option value="reading">読んでる</option>
                                    <option value="finish">読んだよ</option>
                                    <option value="ok">理解した</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger" @click="deleteMyBook(book.id)">delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Loading from '../components/Loading';

export default {
    data() {
        return {
            myBooks: [],
            status: {},
            loading: false,
        }
    },
    components: {
        Loading,
    },
    methods: {
        async fetchMyBooks() {
            //todo: error handling
            this.loading = true;
            const response = await axios.get('/books');
            console.log(response.data.books);
            this.myBooks = response.data.books;
            this.loading = false;
        },
        async deleteMyBook(id) {
            const deleteFlg = confirm('delete?');
            if (!deleteFlg) return;

            const response = await axios.delete(`/books/${id}`).catch(err => err);
            console.log(response);
            this.myBooks = response.data.books;
        },
        async updateStatus(selectedBook) {
            //todo:error handling
            const response = await axios.patch(
                `/books/${selectedBook.id}/status`,
                { 'status': selectedBook.status }
            ).catch(err => err);
            console.log(response);
        }
    },
    created() {
        this.fetchMyBooks();
    },
    beforeCreate() {
        this.$store.commit('showMenu');
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

</style>
