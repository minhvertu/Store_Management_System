<template>
    <div class="lvPage">
        <!-- Navbar -->
        <navbar_fashion></navbar_fashion>

        <!-- Header -->
        <header_lv></header_lv>

        <!-- Section: Collection -->
        <section id="collection" class="py-5">
            <div class="container">
                <div class="title text-center">
                    <h2 class="position-relative d-inline-block">New Collection</h2>
                </div>

                <div class="row g-0">
                    <!-- Sidebar -->
                    <div class="col-lg-2">
                        <!-- Category Filter -->
                        <h2 class="sidebar-title">Category</h2>
                        <ul class="list-group list-group-flush sidebar">
                            <li class="list-group-item" @click="currentCategory = 'all'" :class="{ active: currentCategory === 'all' }">
                                All
                            </li>
                            <li v-for="category in categories" :key="category.id" class="list-group-item" @click="currentCategory = category.id" :class="{ active: currentCategory === category.id }">
                                {{ category.name }}
                            </li>
                        </ul>

                        <!-- Gender Filter -->
                        <h2 class="sidebar-title">Gender</h2>
                        <ul class="list-group list-group-flush sidebar">
                            <li class="list-group-item" @click="currentGender = 'all'" :class="{ active: currentGender === 'all' }">
                                All
                            </li>
                            <li v-for="gender in genders" :key="gender.id" class="list-group-item" @click="currentGender = gender.id" :class="{ active: currentGender === gender.id }">
                                {{ gender.name }}
                            </li>
                        </ul>
                    </div>

                    <!-- Product List -->
                    <div class="col">
                        <div class="collection-list mt-4 row gx-0 gy-3">
                            <template v-for="product in filteredProducts()" :key="product.id">
                                <div class="col-md-6 col-lg-4 col-xl-3 p-2">
                                    <router-link :to="`/products/productDetail/${product.id}`">
                                        <div class="collection-img position-relative">
                                            <img :src="'/storage/' + product.image" class="w-100" alt="Product Image">
                                            <span class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                                        </div>
                                    </router-link>
                                    <div class="text-center">
                                        <p class="text-capitalize my-1">{{ product.name }}</p>
                                        <span class="fw-bold">$ {{ product.sell_price }}</span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pagination -->
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

        <!-- Footer -->
        <footer_fashion></footer_fashion>
    </div>
</template>

<script>
import axios from 'axios';
import navbar_fashion from '../../fashion_store/NavbarFashion.vue';
import header_lv from '../../fashion_store/LV/HeaderLV.vue';
import footer_fashion from '../../fashion_store/FooterFashion.vue';

export default {
    name: "lv_page",
    components: {
        navbar_fashion,
        header_lv,
        footer_fashion,
    },
    data() {
        return {
            currentCategory: 'all', // Danh mục hiện tại
            currentGender: 'all', // Giới tính được chọn ('all' cho tất cả hoặc gender_id)
            products: [],
            categories: [],
            genders: [],
            currentPage: 1,
            pageSize: 12,
        };
    },
    created() {

        this.getProducts();
        this.getCategories();
        this.getGenders();

        const savedPage = localStorage.getItem('currentPage');
        if (savedPage) {
            this.currentPage = parseInt(savedPage, 10);
        }
    },
    methods: {
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
        // Lấy danh sách sản phẩm từ API
        getProducts() {
            axios.get('api/products')
                .then(response => {
                    this.products = response.data.filter(product => product.brand_id === 3);
                    console.log(this.products);

                })
                .catch(error => {
                    console.log(error);
                });
        },

        // Lấy danh sách danh mục từ API
        getCategories() {
            axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                    console.log('Categories:', this.categories);
                })
                .catch(error => {
                    console.error('Error fetching categories:', error);
                });
        },

        // Lấy danh sách giới tính từ API
        getGenders() {
            axios.get('/api/genders')
                .then(response => {
                    this.genders = response.data;
                    console.log('Genders:', this.genders);
                })
                .catch(error => {
                    console.error('Error fetching genders:', error);
                });
        },

        // Lọc sản phẩm dựa trên danh mục và giới tính hiện tại
        filteredProducts() {
            let filtered = this.products;

            // Lọc theo danh mục nếu không phải là 'all'
            if (this.currentCategory !== 'all') {
                filtered = filtered.filter(product => product.category_id === this.currentCategory);
            }

            // Lọc theo giới tính nếu không phải là 'all'
            if (this.currentGender !== 'all') {
                filtered = filtered.filter(product => product.gender_id === this.currentGender);
            }

            // Tính toán chỉ số bắt đầu và kết thúc cho phân trang
            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;

            // Trả về danh sách sản phẩm dựa trên trang hiện tại và kích thước trang
            return filtered.slice(startIndex, endIndex);
        },
    },
    computed: {
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
};
</script>


<style>
@font-face {
    font-family: "cloister";
    src: url('../../assets/word_font/CloisterBlack.ttf');
}

:root {
    --lg-font: 'Kaisei Tokumin', serif;
    --sm-font: 'Poppins', sans-serif;
    --pink: #e5345b;
}

.lvPage {

    body {
        font-family: var(--sm-font);
    }

    /* button */
    .bg-primary {
        background-color: var(--pink) !important;
    }

    .btn:not(.nav-btns button) {
        background-color: #fff;
        color: rgb(85, 85, 85);
        padding: 10px 28px;
        border-radius: 25px;
        border: 1px solid rgb(85, 85, 85);
    }

    .btn:not(.nav-btns button):hover {
        background-color: var(--pink);
        color: #fff;
        border-color: var(--pink);
    }

    /* text color */
    .text-primary {
        color: var(--pink) !important;
    }

    /* navbar */
    .navbar {
        -webkit-box-shadow: 0 3px 9px 3px rgba(0, 0, 0, 0.1);
        box-shadow: 0 3px 9px 3px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand img {
        width: 30px;
    }

    .navbar-brand span {
        letter-spacing: 2px;
        font-family: var(--lg-font);
    }

    .nav-link:hover {
        color: var(--pink) !important;
    }

    .nav-item {
        border-bottom: 0.5px solid rgba(0, 0, 0, 0.05);
    }


    /* title */
    .title h2::before {
        position: absolute;
        content: "";
        width: 4px;
        height: 50px;
        background-color: var(--pink);
        left: -20px;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);

    }

    /* collection */
    .active-filter-btn {
        background-color: var(--pink) !important;
        color: #fff !important;
        border-color: var(--pink) !important;
    }

    .filter-button-group .btn:hover {
        color: #fff !important;
    }

    .collection-img span {
        top: 20px;
        right: 20px;
        width: 46px;
        height: 46px;
        border-radius: 50%;
    }


    .collection-img img {
        -webkit-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
        transition: all 0.3s ease;
    }

    .collection-img:hover img {
        -webkit-transform: scale(1.2);
        -ms-transform: scale(1.2);
        transform: scale(1.2);
    }

    /* special */
    .special-img span {
        top: 20px;
        right: 20px;
    }

    .special-list .btn {
        padding: 8px 20px !important;
    }

    .special-img img {
        -webkit-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
        transition: all 0.3s ease;
    }

    .special-img:hover img {
        -webkit-transform: scale(1.2);
        -ms-transform: scale(1.2);
        transform: scale(1.2);
    }

    /* offers */
    #offers {
        background: url(../fashion_store/images/offer_img.jpg) center/cover no-repeat;
    }

    #offers .row {
        min-height: 60vh;
    }

    .offers-content span {
        font-size: 28px;
    }

    .offers-content h2 {
        font-size: 60px;
        font-family: var(--lg-font);

    }

    .offers-content .btn {
        border-color: transparent !important;
    }

    /* about */
    #about {
        background-color: rgba(179, 179, 179, 0.05);
    }

    /* newsletter */
    #newsletter {
        background-color: rgba(179, 179, 179, 0.05);
    }

    #newsletter p {
        max-width: 600px;
    }

    #newsletter .input-group {
        max-width: 500px;
    }

    #newsletter .form-control {
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
    }

    #newsletter .btn {
        background-color: var(--pink);
        color: #fff;
        border-color: var(--pink);
    }

    #newsletter .btn:hover {
        background-color: #000;
        border-color: #000;
    }

    /* footer */
    footer .brand {
        font-family: var(--lg-font);
        letter-spacing: 2px;
    }

    footer a {
        -webkit-transition: color 0.3s ease;
        -o-transition: color 0.3s ease;
        transition: color 0.3s ease;
    }

    footer a:hover {
        color: var(--pink) !important;
    }

    /* media queries */
    @media(min-width: 992px) {
        .nav-item {
            border-bottom: none;
        }
    }

    .brand-font {
        font-family: "cloister" !important;
        color: #000;
        font-size: 50px;

    }

    .bg-dark {
        background-color: #212529 !important;
    }

    .sidebar {
    width: 70%; /* Chiều rộng của sidebar */
    margin-right: 20px; /* Khoảng cách giữa sidebar và nội dung chính */
    border-right: 1px solid #ddd; /* Đường phân cách giữa sidebar và nội dung chính */
}

/* Định dạng cho danh sách nhóm trong sidebar */
.list-group {
    border: none; /* Xóa đường viền xung quanh list group */
    padding: 0;
    margin-bottom: 20px; /* Khoảng cách phía dưới list group */
}

/* Định dạng cho các mục trong list group */
.list-group-item {
    cursor: pointer; /* Cho phép các mục được nhấp chuột */
    padding: 10px 15px; /* Tăng khoảng trống bên trong các mục */
    border: none; /* Xóa đường viền xung quanh mục */

    background-color: transparent; /* Đặt màu nền là trong suốt */
    transition: background-color 0.3s, color 0.3s; /* Hiệu ứng chuyển đổi màu nền và chữ khi hover */
}

.list-group-item.active {
    background-color: transparent; /* Không thay đổi màu nền cho mục được chọn */
    color: #333; /* Màu chữ thông thường */
    font-weight: bold; /* Đậm chữ */
}

/* Định dạng khi hover (di chuột qua) các mục */
.list-group-item:hover {
    background-color: #f0f0f0; /* Màu nền nhẹ khi hover */
}


/* Định dạng cho khu vực danh sách sản phẩm */
.collection-list {
    flex-grow: 1; /* Cho phép khu vực danh sách sản phẩm chiếm phần còn lại của chiều rộng */
}

.sidebar-title {
    font-weight: bold; /* Chữ đậm */
    margin-bottom: 10px; /* Khoảng cách phía dưới tiêu đề */
    color: #333; /* Màu chữ */
}

.pagination li a,
.pagination li span {
    border-radius: 20px;
    padding: 8px 16px;
}

.pagination {
    margin-right: 65px; /* Dịch phần tử sang bên trái */
}


}
</style>
