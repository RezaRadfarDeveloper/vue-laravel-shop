<template>
    <div class="w-[200px] transition-all bg-indigo-700 text-gray-300 py-4 px-2">
        <router-link
            :to="{ name: 'app.dashboard' }"
            class="flex items-center py-3 px-2 transition-colors rounded hover:bg-black/20 mb-2"
        >
            <span class="mr-2 w-6"><HomeIcon /></span>
            <span class="">Dashboard</span>
        </router-link>
        <router-link
            :to="{ name: 'app.products' }"
            class="flex items-center py-3 px-2 transition-colors rounded hover:bg-black/20 mb-2"
        >
            <span class="mr-2 w-6"><ListBulletIcon /></span>
            <span class="">Products</span>
        </router-link>
        <router-link
            :to="{ name: 'app.dashboard' }"
            class="flex items-center py-3 px-2 transition-colors rounded hover:bg-black/20 mb-2"
        >
            <span class="mr-2 w-6"><UsersIcon /></span>
            <span class="">Users</span>
        </router-link>
        <router-link
            :to="{ name: 'app.dashboard' }"
            class="flex items-center py-3 px-2 transition-colors rounded hover:bg-black/20 mb-2"
        >
            <span class="mr-2 w-6"><ChartPieIcon /></span>
            <span class="">Reports</span>
        </router-link>
    </div>
</template>
<script>
import {
    HomeIcon,
    ListBulletIcon,
    UsersIcon,
    ChartPieIcon,
} from "@heroicons/vue/24/outline";
export default {
    components: {
        HomeIcon,
        ListBulletIcon,
        UsersIcon,
        ChartPieIcon,
    },
};
</script>
