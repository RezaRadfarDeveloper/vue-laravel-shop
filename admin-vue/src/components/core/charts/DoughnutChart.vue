<template>
    <Doughnut :data="data" :options="options" />
</template>

<script>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Doughnut } from "vue-chartjs";
import * as doughnutConfig from "./doughnutConfig.js";

ChartJS.register(ArcElement, Tooltip, Legend);

export default {
    name: "DoughnutChart",
    components: {
        Doughnut,
    },
    data() {
        return doughnutConfig;
    },
};
</script>
