<template>
  <div>
    <div v-if="loading" class="pt-70px">
      <Loading/>
    </div>
    <!--    user info-->
    <div v-else>
      <v-row class="ma-0">
        <v-col class="ma-auto"
               cols="12" sm="6" md="6">
          <v-card>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-avatar color="grey" size=70 class="ma-auto">
                  <img :src="icon" alt="avatar">
                </v-avatar>
              </v-col>
              <v-col cols="8">
                <p>{{ user.name }}</p>
                <p><a :href=" url + '/public/' + user.name " target="_blank">public</a></p>
              </v-col>
            </v-row>
          </v-card>
          <div class="d-flex justify-center mt-5">
            <router-link to="/search" class="link-none">
              <v-btn>
                <v-icon left>menu_book</v-icon>
                Add
              </v-btn>
            </router-link>
          </div>
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
                  :key="item"
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
                      :destroy="true"
                      :role="'edit'"
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
  </div>
</template>

<script>
  import Book from "../components/Book";
  import PieChart from "../components/PieChart";
  import Loading from "../components/Loading";

  export default {
    data() {
      return {
        loading: true,
        user: {},
        books: [],
        url: location.origin,
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
      Loading,
    },
    methods: {
      async fetchMyBooks() {
        const response = await axios.get(`/books?page=${this.page}`).catch(err => err.response);
        if (response.status === 200) {
          this.books = response.data.books;
          this.user = response.data.user;
        } else {
          alert('error');
        }
        this.loading = false;
      },
      updateBook: async function (book) {
        const response = await axios.patch(`/books/${book.id}`, book).catch(err => err);
        this.fetchOrError(response.status)
      },
      async deleteBook(id) {
        const deleteFlg = confirm("delete?");
        if (!deleteFlg) return;

        const response = await axios.delete(`/books/${id}`).catch(err => err.response);
        this.fetchOrError(response.status)
      },
      fetchOrError(status) {
        if (status === 200) {
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
                this.books.filter(r => r.status === '未読').length,
                this.books.filter(r => r.status === '読み中').length,
                this.books.filter(r => r.status === '完読').length,
                this.books.filter(r => r.status === '欲しい').length,
              ]
            }
          ],
        };
      },
      icon: function () {
        if (this.user.icon) return this.user.icon;
        return 'https://vuetifyjs.com/apple-touch-icon-180x180.png';
      }
    },
    created() {
      this.$store.commit('showMenu');
      this.fetchMyBooks();
    },

  }
</script>

<style scoped>
  .small {
    max-width: 300px;
    max-height: 300px;
    margin: auto;
    padding: 15px;
  }
  .link-none {
    text-decoration: none;
  }
</style>

