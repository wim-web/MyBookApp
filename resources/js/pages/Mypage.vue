<template>
    <div>
        <h2>mypage</h2>
        <div v-for="book in myBooks">
            <img :src="book.largeImageUrl">
            <p><a :href="book.itemUrl">{{ book.title }}</a></p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            myBooks: [],
        }
    },
    methods: {
        async fetchMyBooks() {
            const response = await axios.get('/api/books');
            console.log(response.data.books);
            this.myBooks = response.data.books;
        }
    },
    created() {
        this.fetchMyBooks();
    }
}
</script>