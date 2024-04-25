<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="input-group rounded " style="width: 55%;">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" v-model="searchKeyword" @input="searchShops" />
                    <span class="input-group-text bg-dark text-light" id="search-addon">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </span>
                </div>
            </div>
            <div class="col">
                <div class="text-end">
                    <router-link to="/sellProducts">
                        <button type="button" class="btn position-relative">
                            <i class="fa fa-shopping-cart"></i>
                        </button>
                    </router-link>
                </div>
            </div>
        </div>
        <section style="background-color: #eee;">
            <div class="text-center container py-5">
                <div class="row">
                    <template v-for="(storage, storageIndex) in filteredShops" :key="storage.id">
                        <div class="col-lg-2 col-md-4 mb-4">
                            <div class="card">
                                <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
                                    data-mdb-ripple-color="light">
                                    <img :src="'/storage/' + storage.product.image" class="w-100" alt="Product image" />
                                </div>
                                <div class="card-body">
                                    <a href="" class="text-reset">
                                        <h5 class="card-title mb-3">{{ storage.product.name }}</h5>
                                    </a>
                                    <!-- <a href="" class="text-reset">
                                            <p>{{ storage.product.category_id }}</p>
                                        </a> -->
                                    <h6 class="mb-1">${{ storage.product.sell_price }}</h6>

                                    <div class="">
                                        <select class="form-select form-select-sm mx-auto"
                                            aria-label=".form-select-lg example" v-model="storage.product.size_id"
                                            style="width: 70px;">
                                            <option disabled value="">Select Sizes</option>
                                            <option v-for="size in sizes" :key="size.id" :value="size.id">
                                                {{ size.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button @click="addToCart(storage)" type="button" class="btn btn-info "
                                data-mdb-ripple-init>Add
                                to Cart</button>
                        </div>
                    </template>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "sellProducts",
    data() {
        return {
            user_permissions: {},
            shops: [],
            shop: {
                id: '',
                name: '',
                phone_number: '',
                address: '',
            },

            storages: [],
            storage: {
                id: '',
                product_id: '',
                shop_id: '',
                amount: '',
            },

            products: [],


            product_size_amounts: [],
            product_size_amount: {
                id: '',
                amount: '',
                storage_id: '',
                size_id: '',

            },
            sizes: [],
            size: {
                id: '',
                name: '',
            },



            imageUrl: null,

            sortKey: "", // Cột hiện tại được sắp xếp
            sortOrders: {}, // Hướng sắp xếp của các cột

            searchKeyword: '',
            listView: true,
            currentPage: 1, // Trang hiện tại
            pageSize: 10, // Số lượng nhân viên trên mỗi trang
            error: {
                message: ''
            },

            cart: [],
        }
    },
    created() {
        this.getProductSizeAmounts();
        this.getSizes();
        this.getShops();
        this.getProducts();
        this.getStorages();

    },

    methods: {

        addToCart(storage) {

            const productToAdd = {
                id: storage.product.id,
                name: storage.product.name,
                price: storage.product.sell_price,
                size_id: storage.product.size_id,
                image: storage.product.image,
                quantity: 1,
            };

            this.$store.dispatch('addToCart', productToAdd);
            alert('Product Added To Cart Succesfully');
            console.log(productToAdd);
        },

        getSizeName(sizeId) {
            const size = this.sizes.find(size => size.id === sizeId);
            return size ? size.name : 'Unknown'; // Trả về tên kích thước hoặc 'Unknown' nếu không tìm thấy
        },

        getSizes() {
            axios.get('api/sizes')
                .then(response => {
                    this.sizes = response.data;
                    console.log(this.sizes);

                })
                .catch(error => {
                    console.log(error);
                });
        },

        getProductSizeAmounts() {
            axios.get('api/product_size_amounts')
                .then(response => {
                    this.product_size_amounts = response.data;
                    console.log(this.product_size_amounts);

                })
                .catch(error => {
                    console.log(error);
                });
        },

        getStorages() {
            axios.get('api/storages')
                .then(response => {
                    this.storages = response.data;
                    console.log(this.storages);

                })
                .catch(error => {
                    console.log(error);
                });
        },

        getShops() {
            axios.get('api/shops')
                .then(response => {
                    this.shops = response.data;
                    console.log(this.shops);

                })
                .catch(error => {
                    console.log(error);
                });
        },

        getProducts() {
            axios.get('api/products')
                .then(response => {
                    this.products = response.data;
                    console.log(this.products);

                })
                .catch(error => {
                    console.log(error);
                });
        },

        sortBy(key) {
            // Kiểm tra xem cột hiện tại có phải là cột đang được sắp xếp không
            if (this.sortKey === key) {
                // Đảo hướng sắp xếp
                this.sortOrders[key] = this.sortOrders[key] * -1;
            } else {
                // Nếu không phải, đặt cột hiện tại và hướng sắp xếp mới
                this.sortKey = key;
                this.sortOrders[key] = 1;
            }

            // Sắp xếp dữ liệu
            this.filteredShops.sort((a, b) => {
                let modifier = this.sortOrders[key];
                if (a[key] < b[key]) return -1 * modifier;
                if (a[key] > b[key]) return 1 * modifier;
                return 0;
            });
        },

        searchShops() {
            const keyword = this.searchKeyword.toLowerCase();
            this.filteredShops = this.storages.filter(storage => {
                return (
                    storage.product.name.toLowerCase().includes(keyword) ||
                    storage.product.sell_price.toLowerCase().includes(keyword) ||
                    storage.product.product_code.toLowerCase().includes(keyword)
                    // Bạn có thể thêm các thuộc tính khác để tìm kiếm ở đây
                );
            });
        },
        toggleListView() {
            this.listView = !this.listView;
        },

    },

    computed: {
        filteredShops() {

            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;


            const keyword = this.searchKeyword.toLowerCase();
            const filteredShops = this.storages.filter(storage => {
                // Kiểm tra tên sản phẩm hoặc mã sản phẩm để xem có chứa từ khóa tìm kiếm hay không
                return (
                    storage.product.name.toLowerCase().includes(keyword) ||
                    storage.product.sell_price.toLowerCase().includes(keyword) ||
                    storage.product.product_code.toLowerCase().includes(keyword)
                    // Bạn có thể thêm các thuộc tính khác của sản phẩm mà bạn muốn tìm kiếm tại đây
                );
            });
            // Trả về một phần của danh sách đã lọc dựa trên trang hiện tại và kích thước trang
            return filteredShops.slice(startIndex, endIndex);
        },
        totalPages() {
            return Math.ceil(this.shops.length / this.pageSize);
        },
        showPagination() {
            if (this.filteredShops.length >= 4 || this.nextPage > 1) {
                return true;

            } else if (this.filteredShops.length < 5 && this.nextPage == 1) {
                return false;
            }
            return true;
        },

    },
}

</script>
