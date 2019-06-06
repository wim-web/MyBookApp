<template>
    <div>
        <h2>searchするよ</h2>
        <input v-model="searchWord" type="text" placeholder="title">
        <input v-model="searchAuthor" type="text" placeholder="author">
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
            searchWord: '',
            searchAuthor: '',
            books: [],
        }
    },
    components: {
        Book,
    },
    methods: {
        async fetchBooksData () {
            const makedUri = this.makeUri(this.searchWord, this.searchAuthor);
            if (!makedUri) { return alert('どちらか一方を入力しよう') };
            console.log(makedUri)
            //Todo:errorハンドリング
            const response = await axios.get(makedUri);
            console.log(response.data);
            this.books = response.data.items;
        },
        makeUri (searchWord, searchAuthor) {
            if (!searchWord && !searchAuthor) { return false };
            let baseUri = 'https://www.googleapis.com/books/v1/volumes?';
            const qOfWord = 'q=intitle:' + searchWord;
            const qOfAuthor = 'q=inauthor:' + searchAuthor;
            const filter = 'filter=paid-ebooks';
            const langRestrict = 'langRestrict=ja';

            baseUri = searchWord ? baseUri += qOfWord : baseUri;
            baseUri = searchAuthor ? baseUri += qOfAuthor : baseUri;
            const makedUri = baseUri
                            + '&' + filter
                            + '&' + langRestrict;

            return makedUri;
        }
    },
}
</script>
