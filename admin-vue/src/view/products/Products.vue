<template>
    <button @click="getProducts(null)">Add new product</button>
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
    </div>
    <div>
        <div
            v-if="products.isLoading"
            class="flex justify-between items-center min-h-full w-8 h-8"
        >
            <Spinner />
        </div>
        <div v-else>
            <div v-for="product in products.data">
                <div>{{ product.id }}</div>
                <div>{{ product.title }}</div>
                <div>{{ product.price }}</div>
                <div class="w-20 h-16">
                    <img
                        class="w-full h-full"
                        :src="product.image"
                        :alt="product.title"
                    />
                </div>
                <div>{{ product.updated_at }}</div>
            </div>
        </div>
        <div class="flex justify-between items-center w-full px-4">
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

export default {
    components: {
        Spinner,
    },
    setup() {
        const perPage = ref(PRODUCTS_PER_PAGE);
        const search = ref("");

        const products = computed(() => store.state.products);

        onMounted(() => {
            getProducts();
        });

        const getProducts = (url = null) => {
            store.dispatch("getProducts", {
                url,
                search: search.value,
                perPage: perPage.value,
            });
        };

        const getProductsForPage = (event, link) => {
            if (!link.url || link.active) return;
            getProducts(link.url);
        };

        return {
            getProducts,
            getProductsForPage,
            perPage,
            search,
            products,
        };
    },
};
</script>
