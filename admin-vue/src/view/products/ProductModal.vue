<template>
    <div
        id="modal"
        v-if="show"
        class="fixed z-10 left-0 top-0 w-screen h-screen bg-gray-400/50 bg-opacity-10 flex justify-center items-center"
    >
        <div
            v-if="isLoading"
            class="rounded min-h-3/5 bg-white w-[80%] shadow-xl p-8 flex flex-col justify-center items-center"
        >
            <Spinner />
        </div>
        <form
            @submit.prevent="onSubmit"
            v-else
            class="rounded bg-white min-h-3/5 w-[80%] shadow-xl p-8 flex flex-col justify-center items-center"
        >
            <h2 class="text-base/7 font-semibold text-gray-900 mb-8">
                {{
                    product.id
                        ? `Update product ${product.title}`
                        : "Create new product"
                }}
            </h2>
            <div class="flex w-[40%] items-center justify-between mb-8">
                <label
                    for="first-name"
                    class="text-sm/6 font-medium text-gray-900"
                    >Title:</label
                >

                <input
                    type="text"
                    name="first-name"
                    id="first-name"
                    v-model="product.title"
                    autocomplete="given-name"
                    class="block w-[70%] rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
            </div>

            <div class="flex w-[40%] items-center justify-between mb-8">
                <label for="about" class="text-sm/6 font-medium text-gray-900"
                    >Description</label
                >
                <textarea
                    name="description"
                    id="description"
                    rows="3"
                    v-model="product.description"
                    class="block w-[70%] rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                ></textarea>
            </div>
            <div class="flex w-[40%] items-center justify-between mb-8">
                <label
                    for="first-name"
                    class="text-sm/6 font-medium text-gray-900"
                    >Price:</label
                >

                <input
                    type="number"
                    name="first-name"
                    id="first-name"
                    v-model="product.price"
                    autocomplete="given-name"
                    class="block w-[70%] rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
            </div>
            <div class="flex w-[40%] items-center justify-between mb-8">
                <label for="image" class="text-sm/6 font-medium text-gray-900">
                    Image:</label
                >

                <input
                    type="file"
                    name="image"
                    id="image"
                    @change="product.image = $event.target.files[0]"
                    class="block w-[70%] rounded-md cursor-pointer bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
            </div>
            <div class="flex w-[40%] items-center justify-end mb-8">
                <button
                    type="button"
                    @click="closeModal"
                    class="text-sm cursor-pointer rounded bg-gray-300 px-3 py-2 font-semibold w-[35%] shadow-xs hover:bg-gray-200 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-200 text-gray-900"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="rounded-md w-[35%] cursor-pointer bg-indigo-600 px-3 py-2 ml-6 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Save
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { UserCircleIcon } from "@heroicons/vue/24/solid";
import { computed, ref } from "vue";
import store from "../../store";
import Spinner from "../../ui/spinner.vue";

export default {
    props: ["modelValue", "product"],
    emits: ["update:modelValue", "close"],
    components: {
        UserCircleIcon,
        Spinner,
    },

    setup(props, { emit }) {
        const product = ref({
            id: props.product.id,
            title: props.product.title,
            price: props.product.price,
            image: props.product.image,
            description: props.product.description,
        });
        const isLoading = ref(false);

        const show = computed({
            get: () => props.modelValue,
            set: (value) => emit("update:modelValue", value),
        });
        const closeModal = () => {
            show.value = false;
            emit("close");
        };

        const onSubmit = () => {
            isLoading.value = true;
            if (product.value.id) {
                store
                    .dispatch("updateProduct", product.value)
                    .then((response) => {
                        isLoading.value = false;
                        if (response.status === 200) {
                            //TBD show message
                            store.dispatch("getProducts", {});
                            closeModal();
                        }
                    });
            } else {
                store
                    .dispatch("createProduct", product.value)
                    .then((response) => {
                        isLoading.value = false;
                        if (response.status === 201) {
                            //TBD show message
                            store.dispatch("getProducts", {});
                            closeModal();
                        }
                    });
            }
        };

        return {
            show,
            closeModal,
            onSubmit,
            product,
            isLoading,
        };
    },
};
</script>
