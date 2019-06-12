<template>
    <div>
        <form>
            <div class="form-group">
                <label for="username">User Name</label>
                <input type="text" class="form-control" id="username" placeholder="user name" v-model="loginData.name">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="password" v-model="loginData.password">
            </div>
            <button class="btn btn-primary" @click.prevent="tryLogin()">Login</button>
        </form>
        {{loginData}}
    </div>
</template>

<script>
export default {
    data() {
        return {
            loginData: {
                name: '',
                password: '',
            }
        }
    },
    computed: {
        notFillForm() {
            return !this.loginData.name || !this.loginData.password;
        }
    },
    methods: {
        async tryLogin() {
            if (this.notFillForm) return alert('両方埋めて');
            // todo:error handling
            const response = await axios.post('/login', this.loginData).catch(err => err.response);
            console.log(response);
            this.$router.push('/mypage');
        }
    }
}
</script>