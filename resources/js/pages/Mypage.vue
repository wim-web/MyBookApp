<template>
  <div>
    <!--    user info-->
    <v-row class="ma-0">
      <v-col class="ma-auto"
             cols="12" sm="6" md="6">
        <v-card>
          <v-row>
            <v-col cols="4" class="text-center">
              <v-avatar color="grey" size=70 class="ma-auto">
                <img src="https://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar">
              </v-avatar>
            </v-col>
            <v-col cols="8">
              <p>name</p>
              <p>url</p>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <v-col cols="12" sm="6">
        <v-card>
          <PieChart :chart-data="chartData" class="small" :options="options"/>
        </v-card>
      </v-col>
    </v-row>

    <!--    books-->
    <v-card>
      <v-tabs
              background-color="transparent"
              color="black accent-4"
              :grow=true
      >
        <v-tab
                v-for="item in statuses"
                color="#FFE600"
                class="ma-0"
                @click="status = item">{{ item }}
        </v-tab>
      </v-tabs>
      <v-container>
        <v-row>
          <v-col
                  v-for="book in this.filteredBooks"
                  :key="book.id"
                  cols="6"
                  sm="4"
                  lg="3"
          >

            <Book
                    :item="book"
                    @delete="deleteBook(book.id)"
                    @updateBook="updateBook"
            />

          </v-col>
        </v-row>
      </v-container>
    </v-card>

    <!--    tag-->
<!--    <v-chip-->
<!--            class="ma-2"-->
<!--            color="pink"-->
<!--            label-->
<!--            text-color="white"-->
<!--    >-->
<!--      <v-icon left>label</v-icon>-->
<!--      PHP-->
<!--    </v-chip>-->
<!--    <v-chip-->
<!--            class="ma-2"-->
<!--            color="pink"-->
<!--            label-->
<!--            text-color="white"-->
<!--    >-->
<!--      <v-icon left>label</v-icon>-->
<!--      Java-->
<!--    </v-chip>-->
  </div>
</template>

<script>
  import Loading from "../components/Loading";
  import Book from "../components/Book";
  import PieChart from "../components/PieChart";

  export default {
    data() {
      return {
        books: [],
        loading: false,
        statuses: ['すべて', '未読', '読み中', '完読', '欲しい'],
        status: 'すべて',
        options: {
          legend: {
            display: true,
            position: 'top',
          },
          responsive: true,
          maintainAspectRatio: true,
        }
      }
    },
    components: {
      PieChart,
      Book,
      Loading
    },
    methods: {
      async fetchMyBooks() {
        //todo: error handling
        this.loading = true;

        const response = await axios.get(`/books?page=${this.page}`).catch(err => err.response);
        if (response.status === 200) {
          this.books = response.data.data;
        } else {
          alert('error');
        }

        this.loading = false;
      },
      updateBook: async function (book) {
        const response = await axios.patch(`/books/${book.id}`, book)
            .catch(err => err);
        if (response.status !== 200) return alert('error');
        this.fetchMyBooks();
      },
      async deleteBook(id) {
        const deleteFlg = confirm("delete?");
        if (!deleteFlg) return;

        const response = await axios.delete(`/books/${id}`).catch(err => err.response);
        if (response.status === 200) {
          this.fetchMyBooks();
        } else {
          alert('error');
        }
      },
    },
    computed: {
      filteredBooks: function () {
        if (this.status === 'すべて') return this.books;
        return this.books.filter(function (r) {
          if (r.status === this.status) return r;
        }, this);
      },
      chartData: function () {
        return {
          labels: ['未読', '読み中', '完読', '欲しい'],
          datasets: [
            {
              backgroundColor: [
                'rgba(0,255,136,0.6)',
                'rgba(0,170,255,0.6)',
                'rgba(255,0,187,0.6)',
                'rgba(255,230,0,0.6)',
              ],
              data: [
                this.books.filter(function (r) {
                  return r.status === '未読'
                }).length,
                this.books.filter(function (r) {
                  return r.status === '読み中'
                }).length,
                this.books.filter(function (r) {
                  return r.status === '完読'
                }).length,
                this.books.filter(function (r) {
                  return r.status === '欲しい'
                }).length,
              ]
            }
          ],
        };
      }
    },
    created() {
      this.fetchMyBooks();
    },
  };
</script>

<style scoped>
  .small {
    max-width: 300px;
    margin: auto;
    padding: 15px;
  }
</style>

