<template>
    <div class="shoppingCart">
        <navbar_fashion></navbar_fashion>
        <section class="h-100 h-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12">
                        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-lg-8">
                                        <div class="p-5">
                                            <div class="d-flex justify-content-between align-items-center mb-5">
                                                <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                                <h6 class="mb-0 text-muted">{{ cartItems.length }} items</h6>
                                            </div>
                                            <hr class="my-4">

                                            <!-- Hiển thị danh sách sản phẩm trong giỏ hàng -->
                                            <div v-for="(item, index) in cartItems" :key="index" class="row mb-4 d-flex justify-content-between align-items-center">
                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <img :src="'/storage/' + item.image" class="img-fluid rounded-3" :alt="item.name">
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                    <h6 class="text-muted">Shirt</h6>
                                                    <h6 class="text-black mb-0">{{ item.name }}</h6>
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2" @click="decreaseQuantity(item)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>

                                                    <input type="number" class="form-control form-control-sm" v-model="item.quantity">

                                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2" @click="increaseQuantity(item)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                    <h6 class="mb-0">{{ item.price }}</h6>
                                                </div>
                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                    <button class="text-muted" @click="removeFromCart(index)"><i class="fas fa-times"></i></button>
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            <div class="pt-5">
                                                <router-link to="/fashion">
                                                    <h6 class="mb-0"><a href="#!" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a>
                                                    </h6>
                                                </router-link>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 bg-grey">
                                        <div class="p-5">
                                            <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                            <hr class="my-4">

                                            <div class="d-flex justify-content-between mb-4">
                                                <h5 class="text-uppercase">items {{ cartItems.length }}</h5>
                                                <h5>{{ getTotalPrice() }}</h5>
                                            </div>

                                            <h5 class="text-uppercase mb-3">Shipping</h5>

                                            <div class="mb-4 pb-2">
                                                <select class="select">
                                                    <option value="1">Standard-Delivery- €5.00</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                    <option value="4">Four</option>
                                                </select>
                                            </div>

                                            <h5 class="text-uppercase mb-3">Give code</h5>

                                            <div class="mb-5">
                                                <div data-mdb-input-init class="form-outline">
                                                    <input type="text" id="form3Examplea2" class="form-control form-control-lg" />
                                                    <label class="form-label" for="form3Examplea2">Enter your code</label>
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            <div class="d-flex justify-content-between mb-5">
                                                <h5 class="text-uppercase">Total price</h5>
                                                <h5>{{ getTotalPrice() }}</h5>
                                            </div>

                                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark" @click="submitOrder">Register</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer_fashion></footer_fashion>
    </div>
</template>

<script>
import axios from 'axios';
import navbar_fashion from '../../fashion_store/NavbarFashion.vue';
import footer_fashion from '../../fashion_store/FooterFashion.vue';
import index from '../../Sidenav/index.vue';

export default {
    name: "shoppingCart",

    data() {
    return {
        products: [],
        orders:[],
        order_product: {
            id: "",
            amount: "",
            order_id: "",
            product_id: "",
        },
        order: {
                id: '',
                price:'',
                detail:'',
                client_id:'',
                user_id:'',
                status: '',
                products: [], // Mảng sản phẩm trong đơn hàng

            },
    }
},
    computed: {
        cartItems() {
            return this.$store.getters.cartItems;
        }
    },

    methods: {
        removeFromCart(index) {
            this.$store.commit('removeFromCart', index);
        },
        decreaseQuantity(item) {
            if (item.quantity > 1) {
                item.quantity--;
            }
        },
        increaseQuantity(item) {
            item.quantity++;
        },
        getTotalPrice() {
            return this.cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
        },
        submitOrder() {
    // Cập nhật các trường của đơn hàng
    this.order.price = this.getTotalPrice();
    this.order.detail = ''; // Cập nhật chi tiết đơn hàng nếu cần

    // Tạo mảng sản phẩm trong đơn hàng từ giỏ hàng
    this.order.products = this.cartItems.map(item => ({
        id: item.id,
        amount: item.quantity
    }));

    // Gửi đơn hàng lên server
    axios.post('/api/orders', this.order)
        .then(response => {
            // Xử lý khi đơn hàng được gửi thành công
            console.log('Order submitted successfully:', response.data);
            // Xóa giỏ hàng sau khi gửi đơn hàng thành công
            this.$store.commit('clearCart');
            // Sau khi xử lý xong đơn hàng, bạn có thể chuyển người dùng đến trang khác hoặc thực hiện các hành động khác
            window.location.href = '/fashion';
        })
        .catch(error => {
            // Xử lý khi gặp lỗi khi gửi đơn hàng
            console.error('Error submitting order:', error);
        });
}
    },

    components: {
        navbar_fashion,
        index,
        footer_fashion,
    },

    created() {
        const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        this.$store.state.cart = JSON.parse(savedCart); // Khôi phục giỏ hàng từ Local Storage
    }

        this.$store.state.showSidenav = false;
    },
}
</script>



<style>
@media (min-width: 1025px) {
.h-custom {
height: 100vh !important;
}
}

.card-registration .select-input.form-control[readonly]:not([disabled]) {
font-size: 1rem;
line-height: 2.15;
padding-left: .75em;
padding-right: .75em;
}

.card-registration .select-arrow {
top: 13px;
}

.bg-grey {
background-color: #eae8e8;
}

@media (min-width: 992px) {
.card-registration-2 .bg-grey {
border-top-right-radius: 16px;
border-bottom-right-radius: 16px;
}
}

@media (max-width: 991px) {
.card-registration-2 .bg-grey {
border-bottom-left-radius: 16px;
border-bottom-right-radius: 16px;
}
}

</style>
