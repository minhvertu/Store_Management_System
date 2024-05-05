<template>
    <div class="container-fluid">
        <div class="header ">
            <h6>Orders Table</h6>
        </div>

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
                        <button class="btn btn-outline-success" data-mdb-ripple-init data-mdb-ripple-color="dark"
                            @click="exportEmployees">
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
                                Seller</th>
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
                                    <span v-if="order.user" class="text-secondary">{{ order.user.name }}</span>
                                </td>

                                <td class="align-middle text-center">
                                    <span class="text-secondary ">{{ order.status }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="material-symbols-outlined me-2">
                                        <button @click="deleteOrders(order, index)" type="button"
                                            class="btn btn-danger " data-mdb-ripple-init>delete_forever
                                        </button>
                                    </span>
                                    <span class="material-symbols-outlined">
                                        <button type="button" class="btn btn-info" data-mdb-ripple-init
                                            data-bs-toggle="modal" data-bs-target="#updateModal" data-bs-whatever="@mdo"
                                            @click="openUpdateModal(order)">edit</button>
                                    </span>
                                </td>
                            </tr>
                            <td colspan="12">

                                    <div class="collapse" :id="'collapseorder-' + index">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="container mb-5 mt-3">
                                                    <div class="row d-flex align-items-baseline">
                                                        <div class="col-xl-9">
                                                            <p style="color: #7e8d9f;font-size: 20px;">Invoice >>
                                                                <strong>ID: {{ order.order_code }}</strong></p>
                                                        </div>
                                                        <div class="col-xl-3 float-end">
                                                            <a data-mdb-ripple-init
                                                                class="btn btn-light text-capitalize border-0"
                                                                data-mdb-ripple-color="dark"><i
                                                                    class="fas fa-print text-primary"></i> Print</a>
                                                            <a data-mdb-ripple-init
                                                                class="btn btn-light text-capitalize"
                                                                data-mdb-ripple-color="dark"><i
                                                                    class="far fa-file-pdf text-danger"></i> Export</a>
                                                        </div>
                                                        <hr>
                                                    </div>

                                                    <div class="">
                                                        <div class="col-md-12">
                                                            <div class="text-center">
                                                                <h2>Vertu Invoice</h2>
                                                            </div>

                                                        </div>


                                                        <div class="row">
                                                            <div class="col-xl-8">
                                                                <ul class="list-unstyled">
                                                                    <li class="text-muted">To:
                                                                        <span v-if="order.client" style="color:#5d9fc5;">{{ order.client.name }}</span>
                                                                        <span v-else style="color:#5d9fc5;">{{ order.client_name }}</span>
                                                                    </li>
                                                                    <li class="text-muted">
                                                                        <span v-if="order.client">{{ order.client.address }}</span>
                                                                        <span v-else>{{ order.address }}</span>
                                                                    </li>
                                                                    <!-- <li class="text-muted">State, Country</li> -->
                                                                    <li class="text-muted"><span v-if="order.client">{{ order.client.email }}</span></li>
                                                                    <li class="text-muted"><i class="fas fa-phone"></i>
                                                                        <span v-if="order.client">{{ order.client.phone_number }}</span>
                                                                        <span v-else>{{ order.phone_number }}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <p class="text-muted">Invoice</p>
                                                                <ul class="list-unstyled">
                                                                    <li class="text-muted"><i class="fas fa-circle"
                                                                            style="color:#84B0CA ;"></i> <span
                                                                            class="fw-bold">ID:</span>{{ order.order_code }}</li>
                                                                    <li class="text-muted"><i class="fas fa-circle"
                                                                            style="color:#84B0CA ;"></i> <span
                                                                            class="fw-bold">Creation Date: </span>{{ formatDate(order.created_at) }}
                                                                    </li>
                                                                    <li class="text-muted"><i class="fas fa-circle"
                                                                            style="color:#84B0CA ;"></i> <span
                                                                            class="me-1 fw-bold">Status:</span><span
                                                                            class="badge bg-warning text-black fw-bold">
                                                                            {{ order.status }}</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="row my-2 mx-1 justify-content-center">
                                                                <table class="table table-striped table-borderless">
                                                                    <thead style="background-color:#84B0CA ;"
                                                                        class="text-white">
                                                                        <tr>
                                                                            <th></th>
                                                                            <th scope="col" class="center-text">Products</th>
                                                                            <th scope="col" class="center-text">Amount</th>
                                                                            <th scope="col" class="center-text">Detail</th>
                                                                            <th scope="col" class="center-text">Price</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="(order_products, index2) in order.order_product" :key="index2">
                                                                            <td>
                                                                                <div class="image-container" style="width: 70px; height: 70px; overflow: hidden;">
                                                                                    <img :src="'/storage/' + order_products.product.image" alt="Product Image"
                                                                                        class="shadow-sm border-radius-lg border border-1"
                                                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                                                </div>
                                                                            </td>
                                                                            <td class="center-text"> {{ order_products.product.name }}</td>
                                                                            <td class="center-text" >{{ order_products.amount }}</td>

                                                                            <td class="center-text">{{ order.detail }}</td>
                                                                            <td class="center-text">${{ order_products.product.sell_price }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-8">
                                                                <p class="ms-3">Add additional notes and payment
                                                                    information</p>

                                                            </div>
                                                            <div class="col-xl-3">
                                                                <ul class="list-unstyled">
                                                                    <li class="text-muted ms-3"><span
                                                                            class="text-black me-4">SubTotal</span>$1110
                                                                    </li>
                                                                    <li class="text-muted ms-3 mt-2"><span
                                                                            class="text-black me-4">Tax(15%)</span>$111
                                                                    </li>
                                                                </ul>
                                                                <p class="text-black float-start"><span
                                                                        class="text-black me-3"> Total
                                                                        Amount</span><span
                                                                        style="font-size: 25px;">${{ order.price }}</span></p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </td>
                        </template>
                    </tbody>
                </table>
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
                client_id: '',
                client_name: '',
                phone_number: '',
                address: '',

            },
            products: [{
            id: '', amount: ''
            }],


            users: [],
            clients: [],
            shopId: '',
            error: {
                message: ''
            },

        }
    },
    created() {
        this.getOrders();
        this.getUsers();
        this.getClients();
        this.shopId = localStorage.getItem('shop_id');

    },
    methods: {

        formatDate(datetime) {
        // Tạo đối tượng Date từ chuỗi thời gian
        const date = new Date(datetime);

        // Lấy thông tin ngày, tháng, năm
        const day = date.getDate();
        const month = date.getMonth() + 1; // Tháng trong JavaScript là 0-based, nên cần +1
        const year = date.getFullYear();

        // Định dạng ngày tháng theo kiểu 'dd/mm/yyyy' hoặc bạn có thể tùy chỉnh theo định dạng mong muốn
        return `${day}/${month}/${year}`;
    },

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
