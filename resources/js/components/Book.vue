<template>
    <!-- thumbnail, title, url,  -->
    <!-- status, review,  -->
    <div>
        <img :src="bookData.largeImageUrl">
        <p><a :href="bookData.itemUrl">{{ bookData.title }}</a></p>
        <button class="btn btn-outline-primary" @click="addBookMylist(bookData)">mybookに追加</button>
    </div>
</template>

<script>
export default {
    props: {
        bookData: {
            type: Object,
            required: true,
        }
    },
    methods: {
        async addBookMylist (bookData) {
            const response = await axios.post(`/api/books`, DataOfBook);
            console.log(response);
        }
    },
    // created () {
    //     this.DataOfBook = {
    //         'id':               this.AllDataOfBook.id,
    //         'thumbnail_path':   this.AllDataOfBook.volumeInfo.imageLinks.thumbnail,
    //         'url':              this.AllDataOfBook.volumeInfo.infoLink,
    //         'title':            this.AllDataOfBook.volumeInfo.title,
    //     };
    // }
}
</script>