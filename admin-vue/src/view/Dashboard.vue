<template>
    <div
        v-if="isLoading"
        class="flex justify-between items-center min-h-full w-8 h-8"
    >
        <svg
            class="mr-3 -ml-1 size-8 w-12 h-12 animate-spin text-gray-700"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
        >
            <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
            ></circle>
            <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
        </svg>
    </div>
    <div v-else class="flex justify-between items-center">
        <NavBar />
        <button @click="logout">logout</button>
    </div>
</template>

<script>
import { useRouter } from "vue-router";
import store from "../store";
import { onMounted, ref } from "vue";
import NavBar from "../components/NavBar.vue";

export default {
    components: {
        NavBar,
    },
    setup() {
        const router = useRouter();
        const isLoading = ref(false);

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

        onMounted(() => {
            isLoading.value = true;
            store
                .dispatch("getUser")
                .then((response) => {
                    isLoading.value = false;
                    console.log(response);
                })
                .catch((error) => {
                    isLoading.value = false;

                    console.log(error);
                });
        });

        return {
            logout,
            isLoading,
        };
    },
};
</script>
