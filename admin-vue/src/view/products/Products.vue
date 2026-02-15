<template>
    <button @click="showProductModal">Add new product</button>
    <ProductModal
        v-model="showModal"
        @close="closeModalTest"
        :productModal="productModal"
    />
    <div>
        <span>per page</span>
        <select @change="getProducts(null)" v-model="perPage">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <div>
        <input
            type="text"
            v-model="search"
            @change="getProducts(null)"
            placeholder="Type to search products"
        />

        <div>
            <div>
                <div class="flex justify-around">
                    <ColumnTitleCell
                        field="id"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                        @sort-product="sortProduct"
                        >ID</ColumnTitleCell
                    >
                    <ColumnTitleCell
                        field="title"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                        @sort-product="sortProduct"
                        >Title</ColumnTitleCell
                    >
                    <ColumnTitleCell
                        field="price"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                        @sort-product="sortProduct"
                        >Price</ColumnTitleCell
                    >
                    <ColumnTitleCell
                        field="image"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                        @sort-product="sortProduct"
                        >Image</ColumnTitleCell
                    >
                    <ColumnTitleCell
                        field="updated_at"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                        @sort-product="sortProduct"
                        >Updated at</ColumnTitleCell
                    >
                </div>
                <div>
                    <span>Actions</span>
                </div>
                <div
                    v-if="!products.isLoading"
                    class="flex animate-wiggle border-b-1 border-gray-400"
                    :style="{ 'animation-delay': `${i * 0.05}s` }"
                    v-for="(product, i) in products.data"
                >
                    <div>{{ product.id }}</div>
                    <div>{{ product.title }}</div>
                    <div>{{ product.price }}</div>
                    <div class="w-20 h-16">
                        <img
                            class="w-full h-full"
                            :src="product.image_url"
                            :alt="product.title"
                        />
                    </div>
                    <div>{{ product.updated_at }}</div>
                    <div>
                        <button @click="deleteProduct(product.id)">
                            Delete <TrashIcon class="w-6 cursor-pointer" />
                        </button>
                        <button @click="editProduct(product.id)">
                            Edit<PencilIcon class="w-6 cursor-pointer" />
                        </button>
                    </div>
                </div>
                <div
                    v-else
                    class="w-ful h-16 flex justify-center items-center my-5"
                >
                    <div class="flex justify-between items-center min-h-full">
                        <Spinner />
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="!products.isLoading"
            class="flex justify-between items-center w-full px-4"
        >
            <span>Showing from {{ products.from }} to {{ products.to }}</span>
            <nav class="" v-if="products.total > products.limit">
                <a
                    v-for="(link, i) in products.links"
                    :key="i"
                    :disabled="!link.url"
                    href="#"
                    class="inline-flex relative items-center px-4 py-2 border text-sm whitespace-nowrap font-medium"
                    :class="[
                        link.active
                            ? 'z-10 bg-indigo-50 border-b-indigo-500 text-indigo-600'
                            : 'border-gray-300 text-gray-500 bg-white hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === products.links.length - 1 ? 'rounded-r-md' : '',
                    ]"
                    @click.prevent="getProductsForPage($event, link)"
                    aria-current="page"
                    v-html="link.label"
                ></a>
            </nav>
        </div>
    </div>
</template>

<script>
import { computed, onMounted, ref } from "vue";
import Spinner from "../../ui/spinner.vue";
import store from "../../store";
import { PRODUCTS_PER_PAGE } from "../../constants";
import ColumnTitleCell from "../../ui/ColumnTitleCell.vue";
import ProductModal from "./ProductModal.vue";
import { PencilIcon, TrashIcon } from "@heroicons/vue/24/outline";

export default {
    components: {
        Spinner,
        ColumnTitleCell,
        ProductModal,
        TrashIcon,
        PencilIcon,
    },
    setup() {
        const perPage = ref(PRODUCTS_PER_PAGE);
        const search = ref("");
        const sortField = ref("updated_at");
        const sortDirection = ref("desc");
        const showModal = ref(false);
        const productModal = ref({
            id: "",
            title: "",
            price: "",
            description: "",
            image: "",
        });

        const products = computed(() => store.state.products);

        onMounted(() => {
            getProducts();
        });

        const sortProduct = (field) => {
            if (sortField.value === field) {
                if (sortDirection.value === "asc") {
                    console.log("asc");

                    sortDirection.value = "desc";
                } else {
                    sortDirection.value = "asc";
                }
            } else {
                sortField.value = field;
                sortDirection.value = "asc";
            }

            getProducts();
        };

        const getProducts = (url = null) => {
            store.dispatch("getProducts", {
                url,
                search: search.value,
                perPage: perPage.value,
                sort_direction: sortDirection.value,
                sort_field: sortField.value,
            });
        };

        const deleteProduct = (id) => {
            if (!confirm("Are you sure about deleting the product?")) return;
            store.dispatch("deleteProduct", id).then((res) => getProducts());
            console.log("deletes", id);
        };
        const editProduct = (id) => {
            store.dispatch("getProduct", id).then(({ data }) => {
                productModal.value = {
                    id: data.data.id,
                    title: data.data.title,
                    description: data.data.description,
                    image: data.data.image,
                    price: data.data.price,
                };
            });
            showProductModal();
        };

        const showProductModal = () => {
            showModal.value = true;
        };

        const closeModalTest = () => {
            console.log("close emit reached");

            productModal.value = {
                id: "",
                title: "",
                price: "",
                description: "",
                image: "",
            };
        };

        const getProductsForPage = (event, link) => {
            if (!link.url || link.active) return;
            getProducts(link.url);
        };

        return {
            getProducts,
            getProductsForPage,
            deleteProduct,
            editProduct,
            closeModalTest,
            perPage,
            search,
            products,
            sortField,
            sortDirection,
            showModal,
            sortProduct,
            showProductModal,
            productModal,
        };
    },
};
</script>
