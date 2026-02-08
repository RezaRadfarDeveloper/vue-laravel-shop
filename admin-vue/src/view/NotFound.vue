<template>
    <div class="flex justify-center items-center flex-col h-full">
        <div class="flex justify-center items-center mb-4">
            <div
                class="text-6xl block self-stretch font-bold text-indigo-600 align-top border-r-2 py-3 pt-0 px-4 mr-4"
            >
                404
            </div>
            <div>
                <span class="text-6xl font-bold text-black mb-6 inline-block"
                    >Page not found</span
                >
                <div class="flex items-center justify-center">
                    <button>
                        <router-link
                            class="py-2 px-4 cursor-pointer rounded block bg-indigo-500 text-white mr-2"
                            :to="{ name: 'app.dashboard' }"
                            >Go back home</router-link
                        >
                    </button>
                    <button
                        class="py-2 px-4 cursor-pointer rounded bg-gray-300"
                    >
                        Contact support
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
