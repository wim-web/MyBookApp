<template>
    <div>
        <Loading v-if="loading"/>
        <form v-else class="form mt-5">
            <div class="form-group">
                <label for="username">User Name</label>
                <input type="text" class="form-control" id="username" placeholder="user name" v-model="loginData.name">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="password" v-model="loginData.password">
            </div>
            <button class="btn btn-primary" @click.prevent="tryLogin()">Login</button>
            <router-link to="/register" class="ml-3">Register?</router-link>
        </form>
    </div>
</template>

<script>
import Loading from '../components/Loading';
export default {
    data() {
        return {
            loginData: {
                name: '',
                password: '',
            },
            loading: false,
        }
    },
    components: {
        Loading,
    },
    computed: {
        notFillForm() {
            return !this.loginData.name || !this.loginData.password;
        },
    },
    methods: {
        async tryLogin() {
            if (this.notFillForm) return alert('両方埋めて');
            this.loading = true;
            // todo:error handling
            const response = await axios.post('/login', this.loginData).catch(err => err.response);
            console.log(response);
            if (response.status === 200) {
                this.$store.commit('login');
                this.$router.push('/mypage');
            } else {
                alert('エラー');
            }
            this.loading = false;
        }
    },
    beforeCreate() {
        this.$store.commit('hiddenMenu');
    },
}
</script>

<style lang="scss" scoped>
.form {
    max-width: 500px;
    margin: 0 auto;
}
</style>
