<template>
    <main id="Product">
        <div class="error" v-if="error.message.length">
            <div class="alert alert-danger" role="alert">
                {{ error.message }}
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" v-model="searchKeyword" @input="searchProducts" />
                    <span class="input-group-text border" id="search-addon">
                        <span class="material-symbols-outlined">search</span>
                    </span>
                </div>
            </div>
            <div class="col-3">
                <div class="text-end">
                    <router-link to="/products/create" v-if="addPermission" class="p-2 col border btn btn-success">Add
                        Product</router-link>
                    <button class="p-2 col border btn btn-success" style="height: 39px;" @click="toggleListView">
                        <span class="material-symbols-outlined">{{ listView ? 'format_list_bulleted' : 'grid_on' }}</span>
                    </button>
                    <!-- <button class="p-2 col border btn btn-success">Export Excel</button> -->
                    <button class="p-2 col border btn btn-success" @click="exportProducts" >
                        Export Data
                    </button>
                </div>
            </div>
        </div>

        <div>
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col" class="center-text table-primary">ID</th>
                        <th scope="col" class="center-text table-primary">Name</th>
                        <th scope="col" class="center-text table-primary">Product Code</th>
                        <th scope="col" class="center-text table-primary">Amount</th>
                        <th scope="col" class="center-text table-primary">Sales</th>
                        <th scope="col" class="center-text table-primary">Import Price</th>
                        <th scope="col" class="center-text table-primary">Sell Price</th>
                        <th scope="col" class="center-text table-primary">Gender</th>
                        <th scope="col" class="center-text table-primary">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in filteredProducts" :key="product.id">
                        <td class="center-text table-info">{{ product.id }}</td>
                        <td class="center-text table-info">{{ product.name }}</td>
                        <td class="center-text table-info">{{ product.product_code }}</td>
                        <td class="center-text table-info">{{ product.amount }}</td>
                        <td class="center-text table-info">{{ product.sales }}</td>
                        <td class="center-text table-info">{{ product.import_price }}</td>
                        <td class="center-text table-info">{{ product.sell_price }}</td>
                        <td class="center-text table-info">{{ product.gender_item_code }}</td>
                        <td class="center-text table-info">
                            <span class="material-symbols-outlined">
                                <button @click="deleteProduct(product, index)"
                                    class="mx-2 p-2 col border btn btn-sm btn-outline-danger">delete_forever
                                </button>
                            </span>
                            <span class="material-symbols-outlined">
                                <router-link :to="`/products/${product.id}/edit`"
                                    class="mx-2 p-2 col border btn btn-success">edit
                                </router-link>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="showPagination">
                <ul class="pagination justify-content-center">
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
    </main>
</template>

<script>
import axios from 'axios';

export default {
    name: "Product",
    data() {
        return {
            user_permissions: {},
            products: [],
            searchKeyword: '',
            addPermission: true,
            listView: true,
            currentPage: 1, // Trang hiện tại
            pageSize: 5, // Số lượng nhân viên trên mỗi trang
            error: {
                message: ''
            }
        }
    },
    created() {
        this.getProducts();
        this.blockAddPermission();
    },
    methods: {
        getProducts() {
            axios.get('api/products')
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        deleteProduct(product, index) {
            axios.delete('api/products/' + product.id)
                .then(response => {
                    if (response.data.status === false) {
                        this.error.message = response.data.message;
                        setTimeout(() => {
                            this.error.message = '';
                        }, 3000);
                    } else {
                        this.products.splice(index, 1);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        goToPage(page) {
            this.currentPage = page;
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        searchProducts() {
            const keyword = this.searchKeyword.toLowerCase();
            this.filteredProducts = this.products.filter(product => {
                return (
                    product.name.toLowerCase().includes(keyword) ||
                    product.product_code.toLowerCase().includes(keyword) ||
                    product.import_price.includes(keyword) ||
                    product.sell_price.toLowerCase().includes(keyword) ||
                    product.amount.toLowerCase().includes(keyword)||
                    product.gender_item_code.toLowerCase().includes(keyword)
                );
            });
        },
        toggleListView() {
            this.listView = !this.listView;
        },
        blockAddPermission() {
            let user_permissions = JSON.parse(localStorage.getItem('permission_id'));

            for (let i = 0; i < user_permissions.length; i++) {

                if (user_permissions[i].id == 5) {
                    this.addPermission = true;
                    return this.addPermission;
                }
            }
            return this.addPermission = false;
        },

        exportProducts() {
            axios.get('/api/products_export', { responseType: 'arraybuffer' })
                .then(response => {
                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');
                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'products.xlsx');
                    document.body.appendChild(fileLink);
                    fileLink.click();
                    alert('Data exported successfully!');
                })
                .catch(error => {
                    console.error('Export failed:', error);
                    alert('Failed to export data. Please try again later.');
                });
        }
    },
    computed: {
        filteredProducts() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;
            const keyword = this.searchKeyword.toLowerCase();
            const filteredProducts = this.products.filter(product => {
                return (
                    product.name.toLowerCase().includes(keyword) ||
                    product.product_code.toLowerCase().includes(keyword) ||
                    product.import_price.includes(keyword) ||
                    product.sell_price.toLowerCase().includes(keyword) ||
                    product.amount.toLowerCase().includes(keyword)||
                    product.gender_item_code.toLowerCase().includes(keyword)
                );
            });
            return filteredProducts.slice(startIndex, endIndex);
        },
        totalPages() {
            return Math.ceil(this.products.length / this.pageSize);
        },
        showPagination() {
            if (this.filteredProducts.length >= 4 || this.nextPage > 1) {
                return true;

            } else if (this.filteredProducts.length < 5 && this.nextPage == 1) {
                return false;
            }
            return true;
        },

    }
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
</style>
