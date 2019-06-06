<template>
    <!-- thumbnail, title, url,  -->
    <!-- status, review,  -->
    <div>
        <img :src="DataOfBook.thumbnail_path">
        <p><a :href="DataOfBook.url">{{ DataOfBook.title }}</a></p>
        <button class="btn btn-outline-primary" @click="addBookMylist(DataOfBook)">mybookに追加</button>
    </div>
</template>

<script>
export default {
    data () {
        return {
            DataOfBook: {},
        }
    },
    props: {
        AllDataOfBook: {
            type: Object,
            required: true,
        }
    },
    methods: {
        async addBookMylist (DataOfBook) {
            const response = await axios.post(`/api/books`, DataOfBook);
            console.log(response);
        }
    },
    created () {
        this.DataOfBook = {
            'id':               this.AllDataOfBook.id,
            'thumbnail_path':   this.AllDataOfBook.volumeInfo.imageLinks.thumbnail,
            'url':              this.AllDataOfBook.volumeInfo.infoLink,
            'title':            this.AllDataOfBook.volumeInfo.title,
        };
    }
}
</script>