<template>
    <div class="container-fluid" id="Product">
        <div class="error" v-if="error.message.length">
            <div class="alert alert-danger" role="alert">
                {{ error.message }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group rounded " style="width: 55%;">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" v-model="searchKeyword" @input="searchProducts" />
                    <span class="input-group-text bg-dark text-light" id="search-addon">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </span>
                </div>
            </div>
            <div class="col">
                <div class="text-end">
                    <button class="btn btn-outline-info me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                        data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"
                        v-if="addPermission">Create
                        Products</button>
                    <button class="btn btn-outline-success" data-mdb-ripple-init data-mdb-ripple-color="dark"
                        @click="exportProducts">
                        Export Data
                    </button>
                </div>
                <!-- Modal -->

                <form @submit.prevent="submitForm">
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Products Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" type="text" id="name" v-model="product.name" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="import_price" class="form-label">Import Price</label>
                                        <input class="form-control" type="text" id="import_price"
                                            v-model="product.import_price" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="sell_price" class="form-label">Sell Price</label>
                                        <input class="form-control" type="text" id="sell_price"
                                            v-model="product.sell_price" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="detail" class="form-label">Detail</label>
                                        <input class="form-control" type="text" id="detail"
                                            v-model="product.detail" />
                                    </div>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="product.gender_id">
                                        <option disabled value="">Select Gender</option>
                                        <option v-for="gender in genders" :key="gender.id" :value="gender.id">{{ gender.name
                                            }}</option>
                                    </select>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="product.brand_id">
                                        <option disabled value="">Select Brand</option>
                                        <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.name
                                            }}</option>
                                    </select>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="product.category_id">
                                        <option disabled value="">Select Category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}</option>
                                    </select>
                                    <div>
                                        <input type="file" ref="fileInput" multiple @change="onFileChange">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form @submit.prevent="updateProduct">
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- Hiển thị dữ liệu sản phẩm hiện tại -->
                                    <div class="mb-3">
                                        <label for="updateName" class="form-label">Name</label>
                                        <input class="form-control" type="text" id="updateName"
                                            v-model="editedProduct.name" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateImportPrice" class="form-label">Import Price</label>
                                        <input class="form-control" type="text" id="updateImportPrice"
                                            v-model="editedProduct.import_price" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateSellPrice" class="form-label">Sell Price</label>
                                        <input class="form-control" type="text" id="updateSellPrice"
                                            v-model="editedProduct.sell_price" />
                                    </div>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="editedProduct.gender_id">
                                        <option disabled value="">Select Gender</option>
                                        <option v-for="gender in genders" :key="gender.id" :value="gender.id">{{ gender.name
                                            }}</option>
                                    </select>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="editedProduct.brand_id">
                                        <option disabled value="">Select Brand</option>
                                        <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.name
                                            }}</option>
                                    </select>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="editedProduct.category_id">
                                        <option disabled value="">Select Category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}</option>
                                    </select>
                                    <div class="mb-3">
                                        <input type="file" id="updateImage" @change="onUpdateImageChange" />
                                    </div>
                                    <!-- Các trường thông tin khác -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>



                    <div class="modal fade" id="uploadDescriptionImages" tabindex="-1" aria-labelledby="uploadDescriptionImagesLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadDescriptionImagesLabel">Upload Descripion Images</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- Hiển thị dữ liệu sản phẩm hiện tại -->

                                    <div class="mb-3">
                    <input type="file" multiple @change="uploadDescriptionImages(selectedProductId, $event)">
                </div>
                                    <!-- Các trường thông tin khác -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>






            </div>
        </div>

        <div class="table-responsive">
            <table class="table border  " >
                <thead>
                    <tr>
                        <td></td>
                        <th scope="col" class="center-text  text-uppercase" @click="sortBy('product_code')">
                            Product Code
                            <span class="arrow" :class="sortOrders['product_code'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text  text-uppercase" @click="sortBy('name')">
                            Name
                            <span class="arrow" :class="sortOrders['name'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <!-- <th scope="col" class="center-text  text-uppercase" @click="sortBy('category.name')">
                            Product Type
                            <span class="arrow" :class="sortOrders['category.name'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text  text-uppercase" @click="sortBy('import_price')">
                            Import Price
                            <span class="arrow" :class="sortOrders['import_price'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text  text-uppercase" @click="sortBy('sell_price')">
                            Sell Price
                            <span class="arrow" :class="sortOrders['sell_price'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text  text-uppercase" @click="sortBy('gender_id')">
                            Gender
                            <span class="arrow" :class="sortOrders['gender_id'] > 0 ? 'asc' : 'dsc'"></span>
                        </th> -->
                        <th scope="col" class="center-text  text-uppercase" @click="sortBy('brand.name')">
                            Brand
                            <span class="arrow" :class="sortOrders['brand.name'] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                        <th scope="col" class="center-text text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(product, index) in filteredProducts" :key="product.id">
                        <tr data-bs-toggle="collapse" :data-bs-target="'#collapseorder-' + index" aria-expanded="false"
                            aria-controls="collapseExample">
                            <td>
                                <div class="image-container" style="width: 70px; height: 70px; overflow: hidden;">
                                    <img :src="'/storage/' + product.image" alt="Product Image"
                                        class="shadow-sm border-radius-lg border border-1"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </td>
                            <td class="center-text">{{ product.product_code }}</td>
                            <td class="center-text">{{ product.name }}</td>
                            <!-- <td class="center-text">{{ product.category.name }}</td>
                            <td class="center-text">{{ product.import_price }}</td>
                            <td class="center-text">{{ product.sell_price }}</td>
                            <td class="center-text">{{ genderLabel(product.gender_id) }}</td> -->
                            <td class="center-text">{{ product.brand.name }}</td>
                            <td class="center-text">
                                <span class="material-symbols-outlined me-2">
                                    <button @click="deleteProduct(product, index)" type="button" class="btn btn-danger "
                                        data-mdb-ripple-init>delete_forever</button>
                                </span>
                                <span class="material-symbols-outlined me-2">
                                    <button type="button" class="btn btn-info" data-mdb-ripple-init
                                        data-bs-toggle="modal" data-bs-target="#updateModal" data-bs-whatever="@mdo"
                                        @click="openUpdateModal(product)">edit</button>
                                </span>

                                <span class="material-symbols-outlined me-2">
                                    <button type="button" class="btn btn-warning" data-mdb-ripple-init
                                        data-bs-toggle="modal" data-bs-target="#uploadDescriptionImages"   @click="openUploadModal(product.id)" data-bs-whatever="@mdo"
                                        >image</button>
                                </span>

                                <!-- <input type="file" multiple @change="uploadDescriptionImages(product.id, $event)"> -->

                            </td>
                        </tr>
                        <td colspan="12">
    <div class="collapse" :id="'collapseorder-' + index">
        <div class="card card-body">

            <div class="d-flex">

                <div class="image-container me-6" style="width: 15%; height: 15%; overflow: hidden; margin-right: 20px;">
                    <img :src="'/storage/' + product.image" alt="Product Image"
                         class="shadow-sm border-radius-lg border border-1"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <div class="product-info d-flex flex-wrap">

                    <div class="col me-6">
                        <p class="me-3"><strong>Product Code:</strong> {{ product.product_code }}</p>
                        <p class="me-3"><strong>Category:</strong> {{ product.category.name }}</p>
                        <p class="me-3"><strong>Gender:</strong> {{ genderLabel(product.gender_id) }}</p>
                    </div>

                    <div class="col me-6">
                        <p class="me-3"><strong>Import Price:</strong> ${{ product.import_price }}</p>
                        <p class="me-3"><strong>Sell Price:</strong> ${{ product.sell_price }}</p>
                        <p class="me-3"><strong>Brand:</strong> {{ product.brand.name }}</p>
                    </div>

                </div>
            </div>
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
    name: "Product",
    data() {
        return {
            user_permissions: {},
            products: [],
            product: {
                id: '',
                name: '',
                product_type: '',
                import_price: '',
                sell_price: '',
                gender_id: '',
                detail: '',
                brand_id: '',
                category_id: '',
                image: '',
            },

            editedProduct: {
                id: '',
                name: '',
                import_price: '',
                sell_price: '',
                gender_id: '',
                detail: '',
                brand_id: '',
                category_id: '',
                image: '',
            },

            isNewProduct: true,
            imageUrl: null,

            sortKey: "", // Cột hiện tại được sắp xếp
            sortOrders: {}, // Hướng sắp xếp của các cột

            brands: [],
            genders: [],
            categories: [],
            searchKeyword: '',
            addPermission: true,
            listView: true,
            currentPage: 1, // Trang hiện tại
            pageSize: 15, // Số lượng nhân viên trên mỗi trang
            error: {
                message: ''
            },
            roleId: '',
            selectedProductId: null,
        }
    },
    created() {

        const savedPage = localStorage.getItem('currentPage');
        if (savedPage) {
            this.currentPage = parseInt(savedPage, 10);
        }
        this.getProducts();
        this.getBrands();
        this.getGenders();
        this.getCategories();

        this.blockAddPermission();
        this.roleId = localStorage.getItem('role_id');

    },
    methods: {

        openUploadModal(productId) {
        this.selectedProductId = productId;
        // Mở modal (nếu cần)
    },

        async uploadDescriptionImages(productId, event) {
    try {
        // Tạo FormData để chứa các tệp hình ảnh và product_id
        const formData = new FormData();
        const files = event.target.files;

        // Thêm các tệp hình ảnh vào FormData
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        // Thêm product_id vào FormData
        formData.append('product_id', productId);

        // Gửi yêu cầu POST đến API '/upload-description-image' với FormData
        const response = await axios.post('/api/upload-description-image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        // Xử lý phản hồi từ server
        console.log('Description images uploaded successfully:', response.data);
        alert('Description images uploaded successfully!');
        window.location.href = '/productList';

        // Làm mới sản phẩm để cập nhật danh sách các hình ảnh (nếu cần)
        await this.getProducts();

    } catch (error) {
        // Xử lý lỗi nếu có
        console.error('Failed to upload description images:', error);
        alert('Failed to upload description images. Please try again later.');
    }
},


        onUpdateImageChange(event) {
            // Lấy file ảnh từ sự kiện change
            const file = event.target.files[0];
            // Kiểm tra nếu có file ảnh được chọn
            if (file) {
                // Cập nhật ảnh trong biến editedProduct
                this.editedProduct.image = file;
            }
        },
        openUpdateModal(product) {
            // Điền dữ liệu sản phẩm hiện tại vào biến editedProduct
            this.editedProduct = {
                id: product.id,
                name: product.name,
                import_price: product.import_price,
                sell_price: product.sell_price,
                gender_id: product.gender_id,
                detail: product.detail,

                brand_id: product.brand_id,
                category_id: product.category_id,
                image: product.image,
            };
            // Mở modal cập nhật sản phẩm
            $('#updateModal').modal('show');
        },

        async updateProduct() {
            try {
                await axios.put(`/api/products/${this.editedProduct.id}`, this.editedProduct);
                alert('Updated Product Successfully');
                window.location.href = '/productList';
            } catch (error) {
                console.error(error);

            }
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
            this.filteredProducts.sort((a, b) => {
                let modifier = this.sortOrders[key];
                if (a[key] < b[key]) return -1 * modifier;
                if (a[key] > b[key]) return 1 * modifier;
                return 0;
            });
        },
        onFileChange(event) {
            this.product.image = event.target.files[0];
        },
        async submitForm() {
            try {
                const formData = new FormData();
                formData.append('image', this.product.image);
                formData.append('name', this.product.name);
                formData.append('import_price', this.product.import_price);
                formData.append('sell_price', this.product.sell_price);
                formData.append('detail', this.product.detail);

                formData.append('gender_id', this.product.gender_id);
                formData.append('brand_id', this.product.brand_id);
                formData.append('category_id', this.product.category_id);

                await axios.post('/api/products', formData, {
                    header: {
                        'content-Type': 'multipart/form-data'
                    }
                });
                alert('Add Product Successfully');
                window.location.href = '/productList';
            } catch (error) {
                console.error(error);
            }
        },
        genderLabel(genderCode) {
            if (genderCode == 1) {
                return "Male";
            } else {
                return "Female";
            }
        },

        getGenders() {
            axios.get('api/genders')
                .then(response => {
                    this.genders = response.data;
                    console.log(this.genders);

                })
                .catch(error => {
                    console.log(error);
                });
        },

        getBrands() {
            axios.get('api/brands')
                .then(response => {
                    this.brands = response.data;
                    console.log(this.brands);

                })
                .catch(error => {
                    console.log(error);
                });
        },
        getCategories() {
            axios.get('api/categories')
                .then(response => {
                    this.categories = response.data;
                    console.log(this.categories);

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
                    alert('Delete Product Successfully!');
                })
                .catch(error => {
                    console.log(error);
                });
        },
        goToPage(page) {
            this.currentPage = page;
            localStorage.setItem('currentPage', page);
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

                // if ((keyword === 'male' && product.gender_id == 1) || (keyword === 'female' && product.gender_id == 2)) {
                //     return true;
                // }

                return (
                    product.name.toLowerCase().includes(keyword) ||
                    product.category.name.toLowerCase().includes(keyword) ||
                    product.brand.name.toLowerCase().includes(keyword) ||
                    product.product_code.toLowerCase().includes(keyword) ||
                    product.import_price.includes(keyword) ||
                    product.sell_price.toLowerCase().includes(keyword) 
                    // product.gender_id.toLowerCase().includes(keyword)
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
                if ((keyword === 'male' && product.gender_id == 1) || (keyword === 'female' && product.gender_id == 2)) {
                    return true;
                }
                return (

                    product.name.toLowerCase().includes(keyword) ||
                    product.category.name.toLowerCase().includes(keyword) ||
                    product.brand.name.toLowerCase().includes(keyword) ||
                    product.product_code.toLowerCase().includes(keyword) ||
                    product.import_price.includes(keyword) ||
                    product.sell_price.toLowerCase().includes(keyword)
                    // product.gender_id.toLowerCase().includes(keyword)
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

    },
    // async mounted() {
    //     this.imageUrl = response.data.image;
    // },
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
