<template>
  <div>

    <v-img src="/storage/images/top.jpg" max-height="500px">
      <v-overlay
              absolute
              color="grey"
      >
        <div>
          <div class="text-center">
            <v-dialog
                    v-model="indialog"
                    width="500"
            >
              <template v-slot:activator="{ on }">
                <v-btn
                        color="grey"
                        dark
                        v-on="on"
                        @click="indialog = true"
                >
                  Sign In
                </v-btn>
              </template>
              <v-card class="elevation-12">
                <v-toolbar
                        color="grey"
                        dark
                        flat
                >
                  <v-toolbar-title>Sign In</v-toolbar-title>
                  <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text class="pt-5">
                  <v-form>
                    <v-text-field
                            label="User Name"
                            name="login"
                            prepend-icon="person"
                            type="text"
                            v-model="loginData.name"
                            required
                    ></v-text-field>
                    <v-text-field
                            id="password"
                            label="Password"
                            name="password"
                            prepend-icon="lock"
                            type="password"
                            v-model="loginData.password"
                            required
                    ></v-text-field>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="grey" text @click="indialog = false">Close</v-btn>
                  <v-btn color="grey" dark @click="tryLogin()">Login</v-btn>
                </v-card-actions>
              </v-card>

            </v-dialog>

            <v-dialog
                    v-model="updialog"
                    width="500"
            >
              <template v-slot:activator="{ on }">
                <v-btn
                        color="grey"
                        dark
                        v-on="on"
                        @click="updialog = true"
                >
                  Sign Up
                </v-btn>
              </template>
              <v-card class="elevation-12">
                <v-toolbar
                        color="grey"
                        dark
                        flat
                >
                  <v-toolbar-title>Sign Up</v-toolbar-title>
                  <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text class="pt-5">
                  <v-form>
                    <v-text-field
                            label="User Name"
                            name="login"
                            prepend-icon="person"
                            type="text"
                            v-model="registerData.name"
                    ></v-text-field>

                    <v-text-field
                            id="password"
                            label="Password"
                            name="password"
                            prepend-icon="lock"
                            type="password"
                            v-model="registerData.password"
                    ></v-text-field>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="grey" text @click="updialog = false">Close</v-btn>
                  <v-btn color="grey" dark @click="tryRegister()">Register</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </div>
          <div class="text-center mt-5">
            <v-btn color="blue lighten-2 link-none" dark href="/login/twitter">
              <v-icon left color="white">fab fa-twitter</v-icon>
              Sign in or Sign up
            </v-btn>
          </div>
        </div>
      </v-overlay>
    </v-img>

    <div class="text-center mt-5 mb-5">
      <h2 class="font-italic font-weight-bold">Demo</h2>
      <v-icon>fas fa-arrow-down</v-icon>
      <v-icon>fas fa-arrow-down</v-icon>
      <v-icon>fas fa-arrow-down</v-icon>
    </div>
    <div>
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
                      :destroy="false"
                      :role="'edit'"
                      @updateBook="updateBook"
              />

            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </div>
  </div>
</template>

<script>
  import Loading from "../components/Loading";
  import Book from "../components/Book";
  import PieChart from "../components/PieChart";

  export default {
    data() {
      return {
        items: [
          {id: 1, title: 'test', largeImageUrl: 'https://loremflickr.com/640/360/cat?lock=22', status: '未読'},
          {id: 2, title: 'test', largeImageUrl: 'https://loremflickr.com/640/360/cat?lock=2', status: '未読'},
          {id: 3, title: 'test', largeImageUrl: 'https://loremflickr.com/640/360/cat?lock=1', status: '読み中'},
          {id: 4, title: 'test', largeImageUrl: 'https://loremflickr.com/640/360/cat?lock=4', status: '完読'},
          {id: 5, title: 'test', largeImageUrl: 'https://loremflickr.com/640/360/cat?lock=5', status: '完読'},
          {id: 6, title: 'test', largeImageUrl: 'https://loremflickr.com/640/360/cat?lock=6', status: '欲しい'},
          {id: 7, title: 'test', largeImageUrl: 'https://loremflickr.com/640/360/cat?lock=7', status: '未読'},
        ],
        loginData: {
          name: "",
          password: ""
        },
        registerData: {
          name: "",
          password: ""
        },
        loading: false,
        indialog: false,
        updialog: false,
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
      };
    },
    components: {
      Loading,
      Book,
      PieChart,
    },
    methods: {
      async tryLogin() {
        this.loading = true;

        // todo:error handling
        const response = await axios
            .post("/login", this.loginData)
            .catch(err => err.response);
        if (response.status === 200) {
          this.$store.commit("login");
          this.$router.push("/mypage");
        } else {
          alert("エラー");
        }

        this.loading = false;
      },
      async tryRegister() {
        this.loading = true;

        //todo:error handling
        const response = await axios
            .post("/register", this.registerData)
            .catch(err => err.response);
        if (response.status === 201) {
          this.$store.commit("login");
          this.$router.push("/mypage");
        } else {
          alert("エラー");
        }

        this.loading = false;
      },
      updateBook: function (book) {
        this.items = this.items.map(function (r) {
          if (r.id === book.id) return Object.assign({}, book);
          return r;
        })
      }
    },
    computed: {

      filteredBooks: function () {
        if (this.status === 'すべて') return this.items;
        return this.items.filter(function (r) {
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
                this.items.filter(r => r.status === '未読').length,
                this.items.filter(r => r.status === '読み中').length,
                this.items.filter(r => r.status === '完読').length,
                this.items.filter(r => r.status === '欲しい').length,
              ]
            }
          ],
        };
      },
      books: function () {
        return Object.assign({}, this.items);
      }
    },
    beforeCreate() {
      this.$store.commit("hiddenMenu");
    }
  };
</script>

<style lang="scss" scoped>
  .form {
    max-width: 500px;
    margin: 0 auto;
  }

  .link-none {
    text-decoration: none;
  }

  .small {
    max-width: 300px;
    max-height: 300px;
    margin: auto;
    padding: 15px;
  }
</style>
