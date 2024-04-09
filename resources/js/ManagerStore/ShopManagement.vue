<template>
    <div class="container-fluid" id="shops">
        <div class="error" v-if="error.message.length">
            <div class="alert alert-danger" role="alert">
                {{ error.message }}
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="input-group rounded " style="width: 55%;">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" v-model="searchKeyword" @input="searchShops" />
                </div>
            </div>
            <div class="col">
                <div class="text-end">
                    <button type="button" class="p-2 col border btn" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" data-bs-whatever="@mdo" v-if="addPermission">Add
                        Shops</button>

                    <button type="button" class="p-2 col border btn" data-bs-toggle="modal"
                        data-bs-target="#" data-bs-whatever="@mdo" >Storage Check</button>
                    <!-- <button class="p-2 col border btn " @click="exportProducts">
                        Export Data
                    </button> -->
                </div>
                <!-- Modal -->

                <form @submit.prevent="submitForm">
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Shop Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" type="text" id="name" v-model="shop.name" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input class="form-control" type="text" id="address" v-model="shop.address" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input class="form-control" type="text" id="phone_number"
                                            v-model="shop.phone_number" />
                                    </div>

                                    <!-- <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="product.gender_item_code">
                                        <option disabled value="">Select Gender</option>
                                        <option value="1">Nam</option>
                                        <option value="2">Nữ</option>
                                    </select>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="product.category_id">
                                        <option disabled value="">Select Category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}</option>
                                    </select> -->
                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Shop</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form @submit.prevent="updateShop">
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel">Update Shop</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                   
                                    <div class="mb-3">
                                        <label for="updateName" class="form-label">Name</label>
                                        <input class="form-control" type="text" id="updateName"
                                            v-model="editedShop.name" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateAddress" class="form-label">Address</label>
                                        <input class="form-control" type="text" id="updateAddress"
                                            v-model="editedShop.address" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="updatePhoneNumber" class="form-label">Phone Number</label>
                                        <input class="form-control" type="text" id="updatePhoneNumber"
                                            v-model="editedShop.phone_number" />
                                    </div>
                                    

                                    <!-- <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="editedShop.brand_id">
                                        <option disabled value="">Select Brand</option>
                                        <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.name
                                            }}</option>
                                    </select> -->

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Shop</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>



            </div>
        </div>

        <div class="table-responsive">
            <table class="table border ">
                <thead>
                    <tr>
                        <th scope="col" class="center-text" @click="sortBy('name')">
                            Name
                            <span class="arrow" :class="sortOrders['name'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text" @click="sortBy('address')">
                            Address
                            <span class="arrow" :class="sortOrders['address'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text" @click="sortBy('phone_number')">
                            Phone Number
                            <span class="arrow" :class="sortOrders['phone_number'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(shop, index) in filteredShops" :key="shop.id">
                        <tr data-bs-toggle="collapse" :data-bs-target="'#collapseorder-' + index" aria-expanded="false"
                            aria-controls="collapseExample">
                            <td class="center-text">{{ shop.name }}</td>
                            <td class="center-text">{{ shop.address }}</td>
                            <td class="center-text">{{ shop.phone_number }}</td>
                            <td class="center-text">
                                <span class="material-symbols-outlined">
                                    <button @click="deleteShop(shop, index)"
                                        class="mx-2 p-2 col border btn btn-lg btn-outline-danger">delete_forever</button>
                                </span>
                                <span class="material-symbols-outlined">
                                    <button type="button" class="p-2 col border btn" data-bs-toggle="modal"
                                        data-bs-target="#updateModal" data-bs-whatever="@mdo"
                                        @click="openUpdateModal(shop)">edit</button>
                                </span>
                            </td>
                        </tr>
                        <td colspan="12">
                            <div class="collapse" :id="'collapseorder-' + index">
                                <div class="card card-body">
                                    <span class="text-wrap">
                                        What is Lorem Ipsum?
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    </span>
                                </div>
                            </div>
                        </td>
                    </template>
                </tbody>
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
    name: "shopManagement",
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

            editedShop: {
                id: '',
                name: '',
                address: '',
                phone_number: '',
            
            },

            isNewStore: true,
            imageUrl: null,

            sortKey: "", // Cột hiện tại được sắp xếp
            sortOrders: {}, // Hướng sắp xếp của các cột

            searchKeyword: '',
            addPermission: true,
            listView: true,
            currentPage: 1, // Trang hiện tại
            pageSize: 10, // Số lượng nhân viên trên mỗi trang
            error: {
                message: ''
            }
        }
    },
    created() {
        this.getShops();
        this.blockAddPermission();
    },

    methods: {

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

        async updateShop() {
            try {
                await axios.put(`/api/shops/${this.editedShop.id}`, this.editedShop);
                alert('Updated Shop Successfully');
                window.location.href = '/shopManagement';
            } catch (error) {
                console.error(error);

            }
        },

         getShops() {
            axios.get('api/shops')
                .then(response => {
                    this.shops = response.data;
                    console.log(this.stores);

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

        async submitForm() {
            try {
                const formData = new FormData();
                
                formData.append('name', this.shop.name);
                formData.append('address', this.shop.address);
                formData.append('phone_number', this.shop.phone_number);
              

                await axios.post('/api/shops', formData, {
                    header: {
                        'content-Type': 'multipart/form-data'
                    }
                });
                alert('Add Shop Successfully');
                // this.$router.push('/productList');
                window.location.href = '/shopManagement';
            } catch (error) {
                console.error(error);
            }
        },

        deleteShop(shop, index) {
            axios.delete('api/shops/' + shop.id)
                .then(response => {
                    if (response.data.status === false) {
                        this.error.message = response.data.message;
                        setTimeout(() => {
                            this.error.message = '';
                        }, 3000);
                    } else {
                        this.shops.splice(index, 1);
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
    },

    computed: {
        filteredShops() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;
            const keyword = this.searchKeyword.toLowerCase();
            const filteredShops = this.shops.filter(shop => {
                return (
                    shop.name.toLowerCase().includes(keyword) ||
                    shop.phone_number.toLowerCase().includes(keyword) ||
                    shop.address.includes(keyword) 
                );
            });
            return  filteredShops.slice(startIndex, endIndex);
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
</style>