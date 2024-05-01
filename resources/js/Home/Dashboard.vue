<template>
    <div class="py-4 container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <card
                            :title="stats.money.title"
                            :value="`$${totalShopRevenue-totalShopImportCost}`"
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
                            :value= "totalOrder"
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
                            :value= "totalCustomer"
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
                            :value="totalShopImportCost"
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
            totalOrderPrice: 0,
            totalCustomer: 0,
            totalOrder: 0,
            totalImportCost: 0,
            totalShopRevenue: 0,
            totalShopImportCost: 0,
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
                    title: "Total Revenue",
                    value: "$53,000",
                    percentage: "+55%",
                    iconClass: "fa-regular fa-money-bill-1",
                    detail: "since yesterday",
                    iconBackground: "bg-gradient-primary",
                },
                users: {
                    title: "Total Orders",
                    value:  "2300",
                    percentage: "+3%",
                    iconClass: "fa-solid fa-cart-shopping",
                    iconBackground: "bg-gradient-danger",
                    detail: "since last week",
                },
                clients: {
                    title: "Total Customers",
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

    created() {
    // Gọi API để lấy tổng giá trị đơn hàng khi component được tạo
    this.getTotalImportCost();
    this.getTotalOrderPrice();
    this.getTotalCustomers();
    this.getTotalOrder();
    this.getShopRevenue();
    this.getShopImportCost();
    },

    methods: {

        async getShopImportCost() {
            try {
                const response = await axios.get('/api/storages/total-import_cost-shop');

                this.totalShopImportCost = response.data.totalShopImportCost;
            } catch (error) {
                console.error(error);
            }
        },

        async getShopRevenue() {
            try {
                const response = await axios.get('/api/orders/total-revenue-shop');

                this.totalShopRevenue = response.data.totalShopRevenue;
            } catch (error) {
                console.error(error);
            }
        },

        async getTotalImportCost() {
            try {
                const response = await axios.get('/api/storages/total-import-cost');

                this.totalImportCost = response.data.totalImportCost;
            } catch (error) {
                console.error(error);
            }
        },
        async getTotalOrderPrice() {
            try {
                const response = await axios.get('/api/orders/total-price');

                this.totalOrderPrice = response.data.totalOrderPrice;
            } catch (error) {
                console.error(error);
            }
        },
        async getTotalCustomers() {
            try {
                const response = await axios.get('/api/users/total-customers');

                this.totalCustomer = response.data.totalCustomer;
            } catch (error) {
                console.error(error);
            }
        },
        async getTotalOrder() {
            try {
                const response = await axios.get('/api/orders/total-shop-order');

                this.totalOrder = response.data.totalOrder;
            } catch (error) {
                console.error(error);
            }
        }

    }
};
</script>
