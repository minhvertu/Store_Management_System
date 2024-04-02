<template>
    <div class="py-4 container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <card
                            :title="stats.money.title"
                            :value="stats.money.value"
                            :percentage="stats.money.percentage"
                            :iconClass="stats.money.iconClass"
                            :iconBackground="stats.money.iconBackground"
                            :detail="stats.money.detail"
                            directionReverse
                        ></card>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <card
                            :title="stats.users.title"
                            :value="stats.users.value"
                            :percentage="stats.users.percentage"
                            :iconClass="stats.users.iconClass"
                            :iconBackground="stats.users.iconBackground"
                            :detail="stats.users.detail"
                            directionReverse
                        ></card>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <card
                            :title="stats.clients.title"
                            :value="stats.clients.value"
                            :percentage="stats.clients.percentage"
                            :iconClass="stats.clients.iconClass"
                            :iconBackground="stats.clients.iconBackground"
                            :percentageColor="stats.clients.percentageColor"
                            :detail="stats.clients.detail"
                            directionReverse
                        ></card>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <card
                            :title="stats.sales.title"
                            :value="stats.sales.value"
                            :percentage="stats.sales.percentage"
                            :iconClass="stats.sales.iconClass"
                            :iconBackground="stats.sales.iconBackground"
                            :detail="stats.sales.detail"
                            directionReverse
                        ></card>
                    </div>
                    <div class="row" >
                        <p class="h3">Doanh thu</p>
                    </div>
                    <div class="col">
                        <Bar
                            id="my-chart-id"
                            :options="chartOptions"
                            :data="chartData"
                            style="width: 70vw; height: vh"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Bar } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, } from "chart.js";
import Card from "../Cards/Card.vue";
import Carousel from "../components/Carousel.vue";
import CategoriesCard from "../Cards/CategoriesCard.vue";

ChartJS.register( Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale );

export default {
    name: "dashboard",
    components: {
        Bar,
        Card,
        Carousel,
        CategoriesCard,
    },
    data() {
        return {
            chartData: {
                labels: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    " December",
                ],
                datasets: [
                    {
                        label: "Data One",
                        backgroundColor: "#70e6de",
                        data: [40, 39, 10, 40, 39, 80, 40, 100, 200, 0, 15, 19],
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
            },
            stats: {
                money: {
                    title: "Today's Money",
                    value: "$53,000",
                    percentage: "+55%",
                    iconClass: "fa-regular fa-money-bill-1",
                    detail: "since yesterday",
                    iconBackground: "bg-gradient-primary",
                },
                users: {
                    title: "Today's Users",
                    value: "2,300",
                    percentage: "+3%",
                    iconClass: "fa-solid fa-globe",
                    iconBackground: "bg-gradient-danger",
                    detail: "since last week",
                },
                clients: {
                    title: "New Clients",
                    value: "+3,462",
                    percentage: "-2%",
                    iconClass: "fa-regular fa-user",
                    percentageColor: "text-danger",
                    iconBackground: "bg-gradient-success",
                    detail: "since last quarter",
                },
                sales: {
                    title: "Sales",
                    value: "$103,430",
                    percentage: "+5%",
                    iconClass: "fa-solid fa-arrow-trend-up",
                    iconBackground: "bg-gradient-warning",
                    detail: "than last month",
                },
            },
        };
    },
};
</script>
