<template>
    <div class="container-fluid" id="shops">
        <div class="error" v-if="error.message.length">
            <div class="alert alert-danger" role="alert">
                {{ error.message }}
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="input-group rounded" style="width: 55%;">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" v-model="searchKeyword" @input="searchShops" />
                    <span class="input-group-text bg-dark text-light" id="search-addon">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </span>
                </div>
            </div>
            <div class="col">
                <div class="text-end">



                </div>


            </div>
        </div>

        <div class="table-responsive">
            <table class="table " style="border: 1px ; border-radius: 5px;">

                    <template v-for="(shop, shopIndex) in filteredShops" :key="'shop-' + shopIndex">

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col" class="center-text"></th>
                                                        <th scope="col" class="center-text">Name</th>
                                                        <th scope="col" class="center-text">Product Code</th>
                                                        <th scope="col" class="center-text">Detail</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template v-for="(storage, storageIndex) in storages"
                                                        :key="'storage-' + storageIndex">
                                                        <template v-if="storage.shop_id === shop.id">
                                                            <tr>
                                                                <td class="center-text">
                                                                    <div class="image-container"
                                                                        style="width: 50px; height: 50px; overflow: hidden;">
                                                                        <img :src="'/storage/' + storage.product.image"
                                                                            alt="Product Image"
                                                                            class="shadow-sm border-radius-lg border border-1"
                                                                            style="width: 100%; height: 100%; object-fit: cover;" />
                                                                    </div>
                                                                </td>
                                                                <td class="center-text">{{ storage.product.name }}</td>
                                                                <td class="center-text">{{ storage.product.product_code
                                                                    }}</td>
                                                                <td class="center-text">
                                                                    <template
                                                                        v-for="(productSizeAmount, psaIndex) in storage.product_size_amount"
                                                                        :key="'psa-' + psaIndex">
                                                                        <div> Size: {{
                                                                                    getSizeName(productSizeAmount.size_id) }} -
                                                                            Amount: {{ productSizeAmount.amount }}</div>
                                                                    </template>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                </tbody>

                                            </table>
                                        </div>
                    </template>
            </table>




            <div v-if="showPagination">
                <ul class="pagination justify-content-end" style="font-size: 80%;">
                    <li :class="{ 'disabled': currentPage === 1 }">
                        <a class="page-link" href="#" @click.prevent="prevPage">Previous</a>
                    </li>
                    <li v-for="page in totalPages" :key="page" :class="{ 'active': currentPage === page }">
                        <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
                    </li>
                    <li :class="{ 'disabled': currentPage === totalPages }">
                        <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
                    </li>
                </ul>
            </div>
        </div>

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
            }
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

        openProductCheckModal(storage) {
            // Điền dữ liệu sản phẩm hiện tại vào biến editedProduct
            this.storage = {
                id: storage.id,
                shop_id: storage.shop_id,
                product_id: storage.product_id,
                amount: storage.amount,
            };
            // Mở modal cập nhật sản phẩm
            $('#productCheckModal').modal('show');
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

        openUpdateModal(shop) {
            // Điền dữ liệu sản phẩm hiện tại vào biến editedShop
            this.editedShop = {
                id: shop.id,
                name: shop.name,
                address: shop.address,
                phone_number: shop.phone_number,

            };
            // Mở modal cập nhật sản phẩm
            $('#updateModal').modal('show');
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
            this.filteredShops = this.shops.filter(shop => {
                return (
                    shop.name.toLowerCase().includes(keyword) ||
                    shop.address.toLowerCase().includes(keyword) ||
                    shop.phone_number.toLowerCase().includes(keyword)
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
            const filteredShops = this.shops.filter(product => {
                return (
                    product.name.toLowerCase().includes(keyword) ||
                    shop.phone_number.toLowerCase().includes(keyword) ||
                    shop.address.includes(keyword)
                );
            });
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

<style lang="scss" scoped>
.error {
    margin-bottom: 15px;
}

.center-text {
    text-align: center;
}

.table-bordered td {
    border: 1px solid #dee2e6;
    padding: 8px;
    text-align: center;
}

.image-container:hover img {
    transform: scale(1.2);
    transition: transform 0.3s ease;
}

.pagination li a,
.pagination li span {
    border-radius: 20px;
    padding: 8px 16px;
}


/* CSS cho hình mũi tên chỉ ra hướng sắp xếp */
.arrow {
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 0.25em;
    vertical-align: middle;
    border-top: 0.3em solid;
    border-right: 0.3em solid transparent;
    border-bottom: none;
    border-left: 0.3em solid transparent;
}

.asc {
    border-top: none;
    border-bottom: 0.3em solid;
}

.dsc {
    border-top: 0.3em solid;
    border-bottom: none;
}

.image-container:hover img {
    transform: scale(1.2);
    transition: transform 0.3s ease;
}
</style>
