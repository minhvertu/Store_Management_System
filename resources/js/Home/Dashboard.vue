<template>
    <div class ="container-fluid">
        <div class="row">
            <div class="col">
                <Bar id="my-chart-id" :options="chartOptions" :data="chartData" style="width: 70vw; height: vh;"/>
            </div>
        </div>
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'dashboard',
    components: { Bar },
    data() {
        return {
            chartData: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', ' December'],
                datasets: [
                    {
                        label: 'Data One',
                        backgroundColor: '#70e6de',
                        data: [40, 39, 10, 40, 39, 80, 40, 100, 200, 0, 15, 19]
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                
            }
        }
    },
}
</script>