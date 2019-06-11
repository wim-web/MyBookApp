<template>
    <div>
        <main>
            <div class="container">
                header
                <router-link to="/">top</router-link>
                <router-link to="/mypage">mypage</router-link>
                <transition name="router" mode="out-in">
                    <router-view></router-view>
                </transition>
            </div>
        </main>
    </div>
</template>

<style lang="scss" scoped>
.router-enter,
.router-leave-to {
    opacity: 0;
}

.router-enter-active,
.router-leave-active {
    transition: opacity .5s;
}

</style>
