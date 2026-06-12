<template>
    <Doughnut :data="data" :options="options" />
</template>

<script>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Doughnut } from "vue-chartjs";
// import * as doughnutConfig from "./doughnutConfig.js";
import { onMounted, ref } from "vue";

ChartJS.register(ArcElement, Tooltip, Legend);

export default {
    name: "DoughnutChart",
    props: ["data"],
    components: {
        Doughnut,
    },
    setup(props) {
        const data = ref({
            labels: ["VueJs", "EmberJs", "ReactJs", "AngularJs"],
            datasets: [
                {
                    backgroundColor: [
                        "#41B883",
                        "#E46651",
                        "#00D8FF",
                        "#DD1B16",
                    ],
                    data: [60, 20, 60, 10],
                },
            ],
        });
        const options = ref({ responsive: true, maintainAspectRatio: false });
        onMounted(() => {
            data.value = props.data;
        });
        return { data, options };
    },
};
</script>
