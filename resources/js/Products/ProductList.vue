<template>
    <div class ="container-fluid" id="Product">
        <div class="error" v-if="error.message.length">
            <div class="alert alert-danger" role="alert">
                {{ error.message }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" v-model="searchKeyword" @input="searchProducts" />
                    <span class="input-group-text border" id="search-addon">
                        <span class="material-symbols-outlined">search</span>
                    </span>
                </div>
            </div>
            <div class="col">
                <div class="text-end">
                    <button type="button" class="p-2 col border btn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" data-bs-whatever="@mdo">Create Products</button>
                    <!-- <router-link to="/products/create" v-if="addPermission" class="p-2 col border btn ">
                        Add Product
                    </router-link> -->
                    <button class="p-2 col border btn " @click="exportProducts" >
                        Export Data
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Products Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Amount</label>
                                            <input class="form-control" type="text" id="name" v-model="products.amount" />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                   <button type="submit"  class="btn btn-primary">Add Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table border ">
                <thead>
                    <tr>
                        <th scope="col" class="center-text ">Product Code</th>
                        <th scope="col" class="center-text ">Name</th>
                        <th scope="col" class="center-text ">Product Code</th>
                        <th scope="col" class="center-text ">Amount</th>
                        <th scope="col" class="center-text ">Product Type</th>
                        <th scope="col" class="center-text ">Import Price</th>
                        <th scope="col" class="center-text ">Sell Price</th>
                        <th scope="col" class="center-text ">Gender</th>
                        <th scope="col" class="center-text ">Size</th>
                        <th scope="col" class="center-text ">Brand</th>
                        <th scope="col" class="center-text ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in filteredProducts" :key="product.id">
                        <td class="center-text ">{{ product.product_code }}</td>
                        <td class="center-text ">{{ product.name }}</td>
                        <td class="center-text ">{{ product.amount }}</td>
                        <td class="center-text ">{{ product.category.name }}</td>
                        <td class="center-text ">{{ product.import_price }}</td>
                        <td class="center-text ">{{ product.sell_price }}</td>
                        <td class="center-text ">{{ product.gender_item_code }}</td>
                        <td class="center-text ">{{ product.size }}</td>
                        <td class="center-text ">{{ product.brand.name }}</td>
                        <td class="center-text ">
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
    </div>
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
                    console.log(this.products);
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
