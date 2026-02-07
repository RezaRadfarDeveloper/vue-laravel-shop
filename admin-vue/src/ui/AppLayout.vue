<template>
    <div class="flex min-h-full bg-gray-200">
        <SideBar />

        <div class="flex-1 h-full">
            <NavBar />
            <main class="p-6">
                <div class="bg-white p-4 rounded-md">
                    <router-view></router-view>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import NavBar from "./NavBar.vue";
import SideBar from "./SideBar.vue";

export default {
    props: ["title"],
    components: {
        SideBar,
        NavBar,
    },
    setup() {},
};
</script>
