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
                        <!-- <button type="button" class="p-2 col border btn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" data-bs-whatever="@mdo">Create Order</button> -->
                        <button class="btn btn-outline-success" data-mdb-ripple-init data-mdb-ripple-color="dark" @click="exportEmployees">
                            Export Data
                        </button>
                    </div>

                    <!-- Modal -->
                    <form @submit.prevent="createOrder">
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Order Information</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="order_detail" class="form-label">Detail</label>
                                                <input class="form-control" type="text" id="detail"
                                                    v-model="order.detail" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Send message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 table-sm " style="border: 1px ; border-radius: 5px;">
                    <thead>
                        <tr>
                            <th class="text-center text-uppercase">
                                order no</th>
                            <th class="text-center text-uppercase">
                                Order Code</th>
                            <th class="text-center text-uppercase">
                                Client</th>
                            <th class="text-center text-uppercase">
                                Status</th>
                            <th class="text-center text-uppercase">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template v-for="(order, index) in orders" :key="'order-' + index">
                            <tr data-bs-toggle="collapse" :data-bs-target="'#collapseorder-' + index"
                                aria-expanded="false" aria-controls="collapseExample">
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary ">{{ order.id }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary ">{{ order.order_code }}</span>
                                </td>

                                <td class="align-middle text-center">
                                    <span class="text-secondary ">{{ order.user.name }}</span>
                                </td>

                                <td class="align-middle text-center">
                                    <span class="text-secondary ">{{ order.status }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="material-symbols-outlined me-2">
                                        <button   @click="deleteOrders(order, index)"
                                            type="button" class="btn btn-danger " data-mdb-ripple-init>delete_forever
                                        </button>
                                    </span>
                                    <span class="material-symbols-outlined">
                                        <button type="button" class="btn btn-info" data-mdb-ripple-init data-bs-toggle="modal"
                                        data-bs-target="#updateModal" data-bs-whatever="@mdo"
                                        @click="openUpdateModal(order)">edit</button>
                                    </span>
                                </td>
                            </tr>
                            <td colspan="12">
                                <div v-for="(order_products, index2) in order.order_product" :key="index2">
                                    <div class="collapse" :id="'collapseorder-' + index">
                                        <div class="card card-body">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th class="align-middle text-lg" scope="col">Information</th>
                                                    <th class="align-middle text-lg" scope="col">Details</th>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-lg">Amount</td>
                                                    <td>{{ order_products.amount }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-lg">Product</td>
                                                    <td>{{ order_products.product.name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-lg">Detail</td>
                                                    <td>{{ order.detail }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-lg">Total Cost</td>
                                                    <td>{{ order.price }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </template>
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
            orders: [
                {
                    order_product: [{

                    }],
                }
            ],
            order: {
                id: '',
                price: '',
                detail: '',
                client_id: '',
                user_id: '',
                status: '',

            },
            products: [{ id: '', amount: '' }],


            users: [],
            clients: [],
           
        }
    },
    created() {
        this.getOrders();
        this.getUsers();
        this.getClients();

    },
    methods: {

        createOrder() {
            // Gửi request POST đến backend để tạo đơn hàng và thêm sản phẩm
            axios.post('/api/orders', {
                amount: this.order.amount,
                price: this.order.price,
                detail: this.order.detail,
                client_id: this.order.client_id,
                user_id: this.order.user_id,
                status: this.order.status,
                products: this.products // Truyền mảng sản phẩm vào request
            })
                .then(response => {
                    // Xử lý khi tạo đơn hàng thành công
                    console.log(response.data);
                })
                .catch(error => {
                    // Xử lý khi có lỗi xảy ra
                    console.error(error);
                });
        },
        getOrders() {
            axios.get('api/orders')
                .then(response => {
                    this.orders = response.data;

                })
                .catch(error => {
                    console.log(error);
                });
        },
        getUsers() {
            axios.get('api/users')
                .then(response => {
                    this.users = response.data;

                })
                .catch(error => {
                    console.log(error);
                });
        },
        getClients() {
            axios.get('api/clients')
                .then(response => {
                    this.clients = response.data;

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

<style></style>
