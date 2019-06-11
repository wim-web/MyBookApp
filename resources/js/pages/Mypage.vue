<template>
    <div>
        <h2>mypage</h2>
        <div v-for="book in myBooks" :key="book.id">
            <img :src="book.largeImageUrl">
            <p><a :href="book.itemUrl">{{ book.title }}</a></p>
            <select v-model="book.status" v-on:change="updateStatus(book)">
                <option disabled value=""></option>
                <option value="want">買いたい</option>
                <option value="wait">積んでる</option>
                <option value="reading">読んでる</option>
                <option value="finish">読んだよ</option>
                <option value="ok">理解した</option>
            </select>
            <button class="btn btn-danger" @click="deleteMyBook(book.id)">delete</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            myBooks: [],
            status: {},
        }
    },
    methods: {
        async fetchMyBooks() {
            //todo: error handling
            const response = await axios.get('/api/books');
            console.log(response.data.books);
            this.myBooks = response.data.books;
        },
        async deleteMyBook(id) {
            const deleteFlg = confirm('delete?');
            if (!deleteFlg) return;

            const response = await axios.delete(`/api/books/${id}`).catch(err => err);
            console.log(response);
            this.myBooks = response.data.books;
        },
        async updateStatus(selectedBook) {
            //todo:error handling
            const response = await axios.patch(
                `/api/books/${selectedBook.id}/status`,
                { 'status': selectedBook.status }
            ).catch(err => err);
            console.log(response);
        }
    },
    created() {
        this.fetchMyBooks();
    }
}
</script>