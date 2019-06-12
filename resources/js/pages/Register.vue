<template>
  <div>
    <Loading v-if="loading"/>
    <form v-else class="form mt-5" @submit.prevent="tryRegister()">
      <div class="form-group">
        <label for="username">User Name</label>
        <input
          type="text"
          class="form-control"
          id="username"
          placeholder="user name"
          v-model="registerData.name"
          required
        >
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          placeholder="password"
          v-model="registerData.password"
          required
        >
      </div>
      <button class="btn btn-success" type="submit">Register</button>
      <router-link to="/" class="ml-3">Login?</router-link>
    </form>
  </div>
</template>

<script>
import Loading from "../components/Loading";
export default {
  data() {
    return {
      registerData: {
        name: "",
        password: ""
      },
      loading: false
    };
  },
  components: {
    Loading
  },
  methods: {
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
</style>
