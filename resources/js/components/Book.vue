<template>
    <!-- thumbnail, title, url,  -->
    <!-- status, review,  -->
    <div>
        <img :src="book.volumeInfo.imageLinks.thumbnail">
        <p><a :href="book.volumeInfo.infoLink">{{ book.volumeInfo.title }}</a></p>
        <button class="btn btn-outline-primary" @click="addBookMylist()">mybookに追加</button>
    </div>
</template>

<script>
export default {
    data () {
        return {

        }
    },
    props: {
        book: {
            type: Object,
            required: true,
        }
    },
    methods: {
        addBookMylist () {
            alert('add');
        }
    }
}
</script>