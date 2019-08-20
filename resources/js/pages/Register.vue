<template>
  <div>
    <Loading v-if="loading"/>
    <v-row  v-else
            align="center"
            justify="center"
    >
      <v-col
              cols="12"
              sm="8"
              md="4"
      >
        <v-card class="elevation-12">
          <v-toolbar
                  color="primary"
                  dark
                  flat
          >
            <v-toolbar-title>Register form</v-toolbar-title>
            <v-spacer></v-spacer>
          </v-toolbar>
          <v-card-text>
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
            <router-link to="/" class="ml-3">Login?</router-link>
            <v-btn color="primary"  @click="tryRegister()">Register</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
<!--    <form v-else class="form mt-5" @submit.prevent="tryRegister()">-->
<!--      <div class="form-group">-->
<!--        <label for="username">User Name</label>-->
<!--        <input-->
<!--          type="text"-->
<!--          class="form-control"-->
<!--          id="username"-->
<!--          placeholder="user name"-->
<!--          v-model="registerData.name"-->
<!--          required-->
<!--        >-->
<!--      </div>-->
<!--      <div class="form-group">-->
<!--        <label for="password">Password</label>-->
<!--        <input-->
<!--          type="password"-->
<!--          class="form-control"-->
<!--          id="password"-->
<!--          placeholder="password"-->
<!--          v-model="registerData.password"-->
<!--          required-->
<!--        >-->
<!--      </div>-->
<!--      <button class="btn btn-success" type="submit">Register</button>-->
<!--      <router-link to="/" class="ml-3">Login?</router-link>-->
<!--    </form>-->
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
