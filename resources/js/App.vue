<template>
  <v-app>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <span class="navbar-brand"><router-link to="/" class="link-none">Shelforest</router-link></span>
      <button
              v-show="toggleMenu"
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarNav"
              aria-controls="navbarNav"
              aria-expanded="false"
              aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul v-show="toggleMenu" class="navbar-nav">
          <li class="nav-item" data-toggle="collapse" data-target="#navbarNav">
            <router-link to="/mypage" class="nav-link">Mypage</router-link>
          </li>
          <li class="nav-item" data-toggle="collapse" data-target="#navbarNav">
            <a href class="nav-link" @click.prevent="tryLogout()">Logout</a>
          </li>
        </ul>
      </div>
    </nav>
    
      <div v-if="loading" class="pt-70px">
        <Loading/>
      </div>
    <v-container class="pt-70px" fluid>
        <transition name="router" mode="out-in">
          <router-view></router-view>
        </transition>
    </v-container>
    
    
  </v-app>
</template>

<script>
import Loading from "./components/Loading";
export default {
  data() {
    return {
      loading: false
    };
  },
  components: {
    Loading
  },
  methods: {
    async tryLogout() {
      //todo:error handling
      const response = await axios.post("/logout").catch(err => err.response);
      if (response.status === 200) {
        this.$store.commit("logout");
      }
      this.$router.push("/");
    }
  },
  computed: {
    toggleMenu() {
      return this.$store.state.toggleMenu;
    }
  }
};
</script>

<style lang="scss" scoped>
.router-enter,
.router-leave-to {
  opacity: 0;
}

.router-enter-active,
.router-leave-active {
  transition: opacity 0.5s;
}

@media (min-width: 768px) {
  .container {
    max-width: 900px;
  }
}

@media (min-width: 992px) {
  .container {
    max-width: 960px;
  }
}

@media (min-width: 1200px) {
  .container {
    max-width: 1140px;
  }
}

.pt-70px {
  padding-top: 70px;
}

  .link-none {
    text-decoration: none;
    color: #fff;
  }
</style>
