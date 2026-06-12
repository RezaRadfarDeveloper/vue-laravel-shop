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
            <label class="font-semibold text-lg">Active Users</label>
            <template v-if="isLoadingDetails.customerCount">
                <Spinner class="m-0" />
            </template>
            <span v-else class="text-3xl">{{ customerCount }}</span>
        </div>
        <!-- active Products -->
        <div
            class="bg-white px-4 py-4 flex flex-col items-center rounded-lg shadow"
        >
            <label class="font-semibold text-lg">Active Products</label>
            <template v-if="isLoadingDetails.productsCount">
                <Spinner class="m-0" />
            </template>
            <span v-else class="text-3xl">{{ productsCount }}</span>
        </div>
        <!-- paid Orders -->
        <div
            class="bg-white px-4 py-4 flex flex-col items-center rounded-lg shadow"
        >
            <label class="font-semibold text-lg">Paid Orders</label>
            <template v-if="isLoadingDetails.ordersCount">
                <Spinner class="m-0" />
            </template>
            <span v-else class="text-3xl">{{ ordersCount }}</span>
        </div>
        <!-- total Income -->
        <div
            class="bg-white px-4 py-4 flex flex-col items-center rounded-lg shadow"
        >
            <label class="font-semibold text-lg">Total Income</label>
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
            <label class="font-semibold text-lg block mb-2"
                >Latest customers</label
            >
            <template v-if="isLoadingDetails.latestCustomers">
                <Spinner class="m-0" />
            </template>
            <div v-else>
                <router-link
                    to="/app"
                    class="flex mb-3 flex-1 px-3 py-2 items-center bg-gray-50"
                    v-for="customer in latestCustomers"
                    :key="customer.id"
                >
                    <div
                        class="w-10 h-10 bg-gray-200 rounded-full flex justify-center items-center mr-3"
                    >
                        <UserIcon class="w-5" />
                    </div>
                    <div class="mb-2 flex flex-col">
                        <h3>
                            {{ customer.first_name }} {{ customer.last_name }}
                        </h3>
                        <p>{{ customer.email }}</p>
                    </div>
                </router-link>
            </div>
        </div>
        <div class="flex bg-white justify-center items-center p-4">
            <template v-if="isLoadingDetails.ordersByCountry">
                <Spinner class="m-0" />
            </template>
            <template v-else>
                <DoughnutChart
                    :width="300"
                    :height="400"
                    :data="ordersByCountry"
                />
            </template>
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
import { UserIcon } from "@heroicons/vue/24/outline";
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
        UserIcon,
    },
    setup() {
        const router = useRouter();

        const isLoading = ref(false);
        const customerCount = ref(0);
        const productsCount = ref(0);
        const ordersCount = ref(0);
        const totalIncome = ref(0);
        const ordersByCountry = ref([]);
        const latestCustomers = ref([]);

        const isLoadingDetails = ref({
            customerCount: true,
            productsCount: true,
            ordersCount: true,
            totalIncome: true,
            ordersByCountry: true,
            latestCustomers: true,
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
                totalIncome.value = Intl.NumberFormat("en-us", {
                    style: "currency",
                    currency: "USD",
                }).format(data);

                isLoadingDetails.value.totalIncome = false;
            });

        const fetchOrdersByCountry = () =>
            axiosClient
                .get("/dashboard/orders-by-country")
                .then(({ data: countries }) => {
                    const chartData = {
                        labels: [],
                        datasets: [
                            {
                                backgroundColor: [
                                    "#41B883",
                                    "#E46651",
                                    "#00D8FF",
                                    "#DD1B16",
                                ],
                                data: [],
                            },
                        ],
                    };
                    console.log(countries);

                    countries.forEach((country) => {
                        chartData.labels.push(country.name);
                        chartData.datasets[0].data.push(country.count);
                    });
                    console.log(chartData);

                    isLoadingDetails.value.ordersByCountry = false;
                    ordersByCountry.value = chartData;
                });

        const fetchLatestCustomers = () =>
            axiosClient
                .get("/dashboard/latest-customers")
                .then(({ data: customers }) => {
                    latestCustomers.value = customers;
                    isLoadingDetails.value.latestCustomers = false;
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
            fetchOrdersByCountry();
            fetchLatestCustomers();
        });

        return {
            logout,
            isLoading,
            isLoadingDetails,
            customerCount,
            productsCount,
            ordersCount,
            totalIncome,
            ordersByCountry,
            latestCustomers,
        };
    },
};
</script>
