<template>
    <div class="container-fluid">
        <div class="header ">
            <h6>Orders Table</h6>
        </div>
        <div class="">
            <div class="row">
                <div class="col">
                    <div class="input-group rounded" style="width: 55%;">
                        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                            aria-describedby="search-addon" v-model="searchKeyword" @input="searchEmployees" />
                    </div>
                </div>
                <div class="col">
                    <div class="text-end">
                        <router-link to="/employees/create" v-if="addPermission" class="p-2 col border btn ">Add
                            Employee</router-link>
                        <button class="p-2 col border btn " @click="exportEmployees">
                            Export Data
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 table-sm ">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">No</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">ID</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                Amount</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                Price</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                Detail</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                Client</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                User</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                Order Code</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(order, index) in orders" :key="'order-' + index" >
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="../../assets/img/team-2.jpg" class="avatar avatar-sm me-3"
                                            alt="user1" />
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ order.id }}</h6>
                                        <!-- <p class="text-xs text-secondary mb-0">{{ order.amount }}</p> -->
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="text-secondary text-xs font-weight-bold">{{ order.id }}</span>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="text-secondary text-xs font-weight-bold">{{ order.amount }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ order.price }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ order.detail }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ order.client.name }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ order.user.name }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ order.order_code }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="material-symbols-outlined">
                                    <button @click="deleteOrders(order, index)"
                                        class="mx-2 p-2 col border btn btn-sm btn-outline-danger">delete_forever
                                    </button>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "orders",
    data() {
        return {
            orders: [],
        }
    },
    created() {
        this.getOrders();
    },
    methods: {
        getOrders() {
            axios.get('api/orders')
                .then(response => {
                    this.orders = response.data;

                })
                .catch(error => {
                    console.log(error);
                });
        },

        deleteOrders(order, index) {
            axios.delete('api/orders/' + order.id)
                .then(response => {
                    if (response.data.status === false) {
                        this.error.message = response.data.message;
                        setTimeout(() => {
                            this.error.message = '';
                        }, 3000);
                    } else {
                        this.orders.splice(index, 1);
                    }
                alert('Orders deleted successfully!');
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },

}
</script>

<style>

</style>