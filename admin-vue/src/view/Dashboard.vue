<template>
    <!-- <div
        v-if="true"
        class="flex justify-between items-center min-h-full w-8 h-8"
    >
        <Spinner />
    </div> -->
    <h1 class="text-3xl">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        <!-- active Users -->
        <div
            class="bg-white px-4 py-4 flex flex-col items-center rounded-lg shadow"
        >
            <label>Active Users</label>
            <template v-if="isLoadingDetails.customerCount">
                <Spinner class="m-0" />
            </template>
            <span v-else class="text-3xl">{{ customerCount }}</span>
        </div>
        <!-- active Products -->
        <div
            class="bg-white px-4 py-4 flex flex-col items-center rounded-lg shadow"
        >
            <label>Active Products</label>
            <template v-if="isLoadingDetails.productsCount">
                <Spinner class="m-0" />
            </template>
            <span v-else class="text-3xl">{{ productsCount }}</span>
        </div>
        <!-- paid Orders -->
        <div
            class="bg-white px-4 py-4 flex flex-col items-center rounded-lg shadow"
        >
            <label>Paid Orders</label>
            <template v-if="isLoadingDetails.ordersCount">
                <Spinner class="m-0" />
            </template>
            <span v-else class="text-3xl">{{ ordersCount }}</span>
        </div>
        <!-- total Income -->
        <div
            class="bg-white px-4 py-4 flex flex-col items-center rounded-lg shadow"
        >
            <label>Total Income</label>
            <template v-if="isLoadingDetails.totalIncome">
                <Spinner class="m-0" />
            </template>
            <span v-else class="text-3xl">{{ totalIncome }}</span>
        </div>
    </div>

    <div
        class="grid grid-flow-row grid-rows-2 md:grid-cols-2 grid-cols-1 gap-4"
    >
        <div
            class="bg-white px-4 py-4 flex flex-col items-center rounded-lg shadow"
        >
            customer
        </div>
        <div class="flex bg-white justify-between items-center p-4">
            <DoughnutChart :width="300" :height="400" />
        </div>
        <div
            class="bg-white px-5 py-4 flex flex-col items-center rounded-lg shadow"
        >
            Products
        </div>
    </div>
</template>

<script>
import { useRouter } from "vue-router";
import store from "../store";
import { onMounted, ref } from "vue";
import Spinner from "../ui/spinner.vue";
import DoughnutChart from "../components/core/charts/DoughnutChart.vue";
import { stringify } from "postcss";
import axiosClient from "../axios.js";

export default {
    components: {
        Spinner,
        DoughnutChart,
    },
    setup() {
        const router = useRouter();

        const isLoading = ref(false);
        const customerCount = ref(0);
        const productsCount = ref(0);
        const ordersCount = ref(0);
        const totalIncome = ref(0);

        const isLoadingDetails = ref({
            customerCount: true,
            productsCount: true,
            ordersCount: true,
            totalIncome: true,
        });

        const fetchCustomers = () =>
            axiosClient.get("/dashboard/customers-count").then(({ data }) => {
                customerCount.value = data;
                isLoadingDetails.value.customerCount = false;
            });
        const fetchProducts = () =>
            axiosClient.get("/dashboard/products-count").then(({ data }) => {
                productsCount.value = data;
                isLoadingDetails.value.productsCount = false;
            });
        const fetchOrders = () =>
            axiosClient.get("/dashboard/orders-count").then(({ data }) => {
                ordersCount.value = data;
                isLoadingDetails.value.ordersCount = false;
            });
        const fetchIncome = () =>
            axiosClient.get("/dashboard/income").then(({ data }) => {
                totalIncome.value = data;
                isLoadingDetails.value.totalIncome = false;
            });

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

        onMounted(() => {
            fetchCustomers();
            fetchProducts();
            fetchOrders();
            fetchIncome();
        });

        return {
            logout,
            isLoading,
            isLoadingDetails,
            customerCount,
            productsCount,
            ordersCount,
            totalIncome,
        };
    },
};
</script>
