<template>
    <div>
        <h2>searchするよ</h2>
        <input v-model="inputTitle" type="text" placeholder="title">
        <input v-model="inputAuthor" type="text" placeholder="author">
        <button class="btn btn-primary" @click="fetchBooksData()">submit</button>
        
        <Book v-for="book in books"
                :key="book.id"
                :AllDataOfBook="book"
        />
    </div>
</template>

<script>
import Book from '../components/Book';
export default {
    data () {
        return {
            inputTitle: '',
            inputAuthor: '',
            books: [],
        }
    },
    components: {
        Book,
    },
    methods: {
        async fetchBooksData() {
            const googleUri = 'https://www.googleapis.com/books/v1/volumes';
            const params = this.setParams(this.inputTitle, this.inputAuthor);
            if (!params) { return alert('どちらか一方を入力しよう') };
            //Todo:errorハンドリング
            const response = await axios.get(googleUri, params).catch(err => err);
            console.log(response);
            this.books = response.data.items;
        },
        setParams(inputTitle, inputAuthor) {
            if (!inputTitle && !inputAuthor) { return false };

            const titleQuery = 'intitle:' + inputTitle;
            const authorQuery = 'inauthor:' + inputAuthor;
            let query = titleQuery + '+' + authorQuery;

            if (!inputTitle) { query = authorQuery }
            if (!inputAuthor) { query = titleQuery }

            return {
                params:{
                    q: query,
                    filter: 'paid-ebooks',
                    langRestrict: 'ja',
                }
            };
        }
    },
}
</script>
