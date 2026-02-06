<template>
    <div
        v-if="isLoading"
        class="flex justify-between items-center min-h-full w-8 h-8"
    >
        <Spinner />
    </div>
    <div v-else class="flex justify-between items-center">
        <NavBar />
        <button @click="logout">logout</button>
        <router-link :to="{ name: 'products' }">products</router-link>
    </div>
</template>

<script>
import { useRouter } from "vue-router";
import store from "../store";
import { onMounted, ref } from "vue";
import NavBar from "../components/NavBar.vue";
import Spinner from "../ui/spinner.vue";

export default {
    components: {
        NavBar,
        Spinner,
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
