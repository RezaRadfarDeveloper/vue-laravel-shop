<template>
    <div class="flex min-h-full">
        <SideBar />

        <div class="flex-1 h-full">
            <header></header>
            <main>
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>

<script>
import SideBar from "./SideBar.vue";

export default {
    props: ["title"],
    components: {
        SideBar,
    },
    setup() {},
};
</script>
