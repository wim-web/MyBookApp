<template>
    <div>
        <h2 class="text-center mb-4">Add Book</h2>
        <form>
            <div class="input-group mb-3">
                <input v-model="inputTitle" class="form-control" type="text" placeholder="タイトルで検索">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" @click.prevent="fetchBooksData()">search</button>
                </div>
            </div>
        </form>
        <Loading v-if="loading"/>
        <Book v-else :books="books" />
    </div>
</template>

<script>

import Book from '../components/Book';
import Loading from '../components/Loading';

export default {
    data () {
        return {
            inputTitle: '',
            inputAuthor: '',
            books: [],
            loading: false,
        }
    },
    components: {
        Book,
        Loading,
    },
    methods: {
        async fetchBooksData() {
            if (!this.inputTitle) return alert('fill into brank');
            //axiosだとcorsに引っかかるので、ここだけajax
            const params = this.setParams(this.inputTitle);

            this.loading = true;

            await $.ajax(
                params
            ).done(data => {
                console.log(data);
                this.books = data.Items
            }).fail(data => {
                //todo:error handling
                console.log(data.responseJSON);
            });

            this.loading = false;
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
                    elements: 'count,page,hits,pageCount,title,author,itemCaption,itemUrl,largeImageUrl',
                },
            }
        }
    },
    beforeCreate() {
        this.$store.commit('showMenu');
    },
}
</script>
