<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <span class="navbar-brand">Navbar</span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item" data-toggle="collapse" data-target="#navbarNav">
                    <router-link to="/mypage" class="nav-link">Mypage</router-link>
                </li>
                <li class="nav-item" data-toggle="collapse" data-target="#navbarNav">
                    <router-link to="/search" class="nav-link">Add</router-link>
                </li>
                <li class="nav-item" data-toggle="collapse" data-target="#navbarNav">
                    <a href="" class="nav-link" @click.prevent="tryLogout()">Logout</a>
                </li>
                <li class="nav-item" data-toggle="collapse" data-target="#navbarNav">
                    <router-link class="nav-link" to="/register">Register</router-link>
                </li>
                </ul>
            </div>
        </nav>
        <main>
            <div class="container pt-70px">
                <transition name="router" mode="out-in">
                    <router-view></router-view>
                </transition>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    methods: {
        async tryLogout() {
            const response = await axios.post('/logout');
            this.$store.commit('logout');
            this.$router.push('/');
        }
    }
}
</script>

<style lang="scss" scoped>
.router-enter,
.router-leave-to {
    opacity: 0;
}

.router-enter-active,
.router-leave-active {
    transition: opacity .5s;
}

@media (min-width: 768px) {
.container {
    max-width: 800px;
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
</style>
