<template>
  <div class="text-center">
    <a href="/login/twitter"  class="btn btn-default btn-md">Log in with Github</a>
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
              <v-btn color="grey"  dark @click="tryLogin()">Login</v-btn>
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
</template>

<script>
import Loading from "../components/Loading";
export default {
  data() {
    return {
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
    };
  },
  components: {
    Loading
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
