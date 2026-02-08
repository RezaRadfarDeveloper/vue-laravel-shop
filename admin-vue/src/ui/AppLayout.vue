<template>
    <div class="flex min-h-full bg-gray-200">
        <SideBar :class="{ '-ml-[200px]': !sidebarIsOpen }" />

        <div class="flex-1 h-full">
            <NavBar @toggle-sidebar="toggleSidebar" />
            <main class="p-6">
                <div class="bg-white p-4 rounded-md">
                    <router-view></router-view>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import { onMounted, onUnmounted, ref } from "vue";
import NavBar from "./NavBar.vue";
import SideBar from "./SideBar.vue";

export default {
    props: ["title"],
    components: {
        SideBar,
        NavBar,
    },
    setup() {
        const sidebarIsOpen = ref(true);

        const toggleSidebar = () => {
            sidebarIsOpen.value = !sidebarIsOpen.value;
        };

        onMounted(() => {
            handleSidebarStatus();
            window.addEventListener("resize", handleSidebarStatus);
        });

        onUnmounted(() => {
            window.removeEventListener("resize", handleSidebarStatus);
        });

        const handleSidebarStatus = () => {
            sidebarIsOpen.value = window.innerWidth > 768;
        };
        return {
            sidebarIsOpen,
            toggleSidebar,
        };
    },
};
</script>
