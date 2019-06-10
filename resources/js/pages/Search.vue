<template>
    <div>
        <h2>searchするよ</h2>
        <input v-model="inputTitle" type="text" placeholder="title">
        <input v-model="inputAuthor" type="text" placeholder="author">
        <button class="btn btn-primary" @click="fetchBooksData()">submit</button>
        
        <Book v-for="book in books"
                :key="book.title"
                :bookData="book"
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
            if (!this.inputTitle) return alert('fill into brank');
            //axiosだとcorsに引っかかるので、ここだけajax
            const params = this.setParams(this.inputTitle);
            $.ajax(
                params
            ).done(data => {
                return console.log(data);
                this.books = data.Items
            }).fail(data => {
                //todo:error handling
                console.log(data.responseJSON);
            });
        },
        setParams(inputTitle) {
            return {
                url: 'https://app.rakuten.co.jp/services/api/BooksTotal/Search/20170404',
                type: 'GET',
                datatype: 'json',
                data: {
                    applicationId: '1019399324990976605', 
                    keyword: inputTitle,
                    formatVersion: 2,
                    elements: 'count,page,hits,pageCount,title,author,itemCaption,itemUrl,largeImageUrl,isbn',
                },
            }
        }
    },
}
</script>
