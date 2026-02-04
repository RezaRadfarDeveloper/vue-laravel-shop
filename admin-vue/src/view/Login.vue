<template>
    <div
        class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2
                class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900"
            >
                Sign in to your account
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="login" method="POST">
                <div>
                    <div
                        v-if="errorMsg"
                        class="flex bg-red-500 justify-between items-center rounded text-white py-3 px-5"
                    >
                        {{ errorMsg }}
                        <span
                            @click="errorMsg = ''"
                            class="flex justify-center items-center w-8 h-8 hover:bg-black/20 transition-colors rounded-full cursor-pointer"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>
                        </span>
                    </div>
                    <label
                        for="email"
                        class="block text-sm/6 font-medium text-gray-900"
                        >Email address</label
                    >
                    <div class="mt-2">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            autocomplete="email"
                            v-model="user.email"
                            required=""
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Password</label
                        >
                        <div class="text-sm">
                            <router-link
                                :to="{
                                    name: 'requestPassword',
                                }"
                                class="font-semibold text-indigo-600 hover:text-indigo-500"
                                >Forgot password?</router-link
                            >
                        </div>
                    </div>
                    <div class="mt-2">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="current-password"
                            v-model="user.password"
                            required=""
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <div class="text-sm flex">
                            <input
                                type="checkbox"
                                name="remember-me"
                                id="remember-me"
                                v-model="user.remember"
                                class="mr-4"
                            />
                            <label
                                for="password"
                                class="block text-sm/6 font-medium text-gray-900"
                                >Remember me:</label
                            >
                        </div>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="isLoading"
                        :class="{
                            'cursor-not-allowed': isLoading,
                            'hover:bg-indigo-500': isLoading,
                        }"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        <svg
                            class="mr-3 -ml-1 size-5 animate-spin text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            v-if="isLoading"
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
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import store from "../store";
import { useRouter } from "vue-router";

export default {
    setup() {
        const user = ref({ email: "", password: "", remember: false });
        const errorMsg = ref("");
        const isLoading = ref(false);

        const router = useRouter();

        const login = () => {
            isLoading.value = true;

            store
                .dispatch("login", user.value)
                .then((data) => {
                    isLoading.value = false;
                    console.log(data);
                    router.push({ name: "dashboard" });
                })
                .catch(({ response }) => {
                    isLoading.value = false;
                    errorMsg.value = response.data.message;
                });
        };

        return {
            user,
            errorMsg,
            isLoading,
            login,
        };
    },
};
</script>
