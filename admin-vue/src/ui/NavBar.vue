<template>
    <header
        class="flex justify-between items-center px-4 h-16 text-gray-700 bg-white"
    >
        <button class="w-10 cursor-pointer rounded-[4px] hover:bg-black/5">
            <Bars3Icon />
        </button>

        <nav class="flex justify-around items-center w-[21rem]">
            <div class="flex cursor-pointer hover:bg-black/5 p-2 rounded-sm">
                <span class="w-6 mr-2"><UserIcon /></span>
                Profile
            </div>
            <div
                @click="logout"
                class="flex cursor-pointer hover:bg-black/5 p-2 rounded-sm"
            >
                <span class="w-6 mr-2"><ArrowRightStartOnRectangleIcon /></span>
                Logout
            </div>
            <div class="flex items-center hover:bg-black/5 p-2 rounded-sm">
                <img
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTxctjU21pUENIsGN1F4qY21P7GfdEbhTMp2g&s"
                    class="w-10 h-10 bg-gray-700 rounded-full mr-2"
                    alt=""
                />
                {{ currentUser.name }}
            </div>
        </nav>
    </header>
</template>
<script>
import {
    Bars3Icon,
    UserIcon,
    ArrowRightStartOnRectangleIcon,
} from "@heroicons/vue/24/outline";

import { computed } from "vue";
import store from "../store";
import { useRouter } from "vue-router";

export default {
    components: {
        Bars3Icon,
        UserIcon,
        ArrowRightStartOnRectangleIcon,
    },
    setup() {
        const router = useRouter();
        const logout = () => {
            store
                .dispatch("logout")
                .then((result) => {
                    router.push({ name: "login" });
                })
                .catch((err) => {
                    console.log(err);
                });
        };
        const currentUser = computed(() => store.state.user.data);

        return {
            currentUser,
            logout,
        };
    },
};
</script>
