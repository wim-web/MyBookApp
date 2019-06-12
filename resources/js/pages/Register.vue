<template>
    <div>
        <form>
            <div class="form-group">
                <label for="username">User Name</label>
                <input type="text" class="form-control" id="username" placeholder="user name" v-model="registerData.name">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="password" v-model="registerData.password">
            </div>
            <button class="btn btn-success" @click.prevent="tryRegister()">Register</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            registerData: {
                name: '',
                password: '',
            }
        }
    },
    methods: {
        async tryRegister() {
            const response = await axios.post('/register', this.registerData).catch(err => err.response);
            console.log(response);
            if (response.status === 201) {
                this.$store.commit('login');
                this.$router.push('/mypage');
            } else {
                alert('エラー');
            }
        }
    }
}
</script>