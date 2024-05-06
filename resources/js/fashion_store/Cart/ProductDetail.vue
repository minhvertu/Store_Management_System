<template>
    <div class="productDetail">
        <navbar_fashion></navbar_fashion>

        <section id="collection" class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="main-img">
                            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="true">
                                <!-- Tạo các mục carousel cho từng hình ảnh -->
                                <div class="carousel-inner">
                                    <!-- Mục đầu tiên là ảnh chính của sản phẩm -->
                                    <div class="carousel-item active">
                                        <img :src="'/storage/' + products.image" class="d-block w-100" alt="Product Image">
                                    </div>
                                    <!-- Các mục còn lại là các hình ảnh mô tả -->
                                    <div v-for="descriptionImage in filteredDescriptionImages" :key="descriptionImage.id"
                                        class="carousel-item">
                                        <img :src="'/storage/' + descriptionImage.image" class="d-block w-100" alt="Description Image">
                                    </div>
                                </div>

                                <!-- Nút điều hướng trước -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev"
                                        style="position: absolute; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; background-color: rgba(0, 0, 0, 0.5); border-radius: 50%; z-index: 10;">
                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="color: white;"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <!-- Nút điều hướng sau -->
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next"
                                        style="position: absolute; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; background-color: rgba(0, 0, 0, 0.5); border-radius: 50%; z-index: 10;">
                                    <span class="carousel-control-next-icon" aria-hidden="true" style="color: white;"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="main-description px-2">
                            <div class="category text-bold">
                                Category: {{ products.category_name }}
                            </div>
                            <div class="product-title text-bold my-3">
                                {{ products.name }}
                            </div>

                            <div class="price-area my-4">
                                <!-- <p class="old-price mb-1"><del>${{  }}</del> <span
                                        class="old-price-discount text-danger">(20% off)</span></p> -->
                                <p class="new-price text-bold mb-1">
                                    ${{ products.sell_price }}
                                </p>
                                <p class="text-secondary mb-1">
                                    (Additional tax may apply on checkout)
                                </p>
                                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                    v-model="products.size_id" style="width: 100px;">
                                    <option disabled value="">Select Sizes</option>
                                    <option v-for="size in sizes" :key="size.id" :value="size.id">
                                        {{ size.name }}
                                    </option>
                                </select>
                            </div>


                            <form @submit.prevent="submitForm">
                                <div class="buttons d-flex my-5">
                                    <div class="block">
                                        <a href="#" class="shadow btn custom-btn">Wishlist</a>
                                    </div>
                                    <div class="block">
                                        <button class="shadow btn custom-btn" @click="addToCart">
                                            Add To Cart
                                        </button>
                                    </div>

                                    <!-- <div class="block quantity">
                                        <input type="number" class="form-control" id="cart_quantity" value="1" min="0"
                                            max="100" v-model="amount" placeholder="Enter email" name="cart_quantity">
                                    </div> -->
                                </div>
                            </form>
                        </div>

                        <div class="product-details my-4">
                            <p class="details-title text-color mb-1">
                                Product Details
                            </p>
                            <p class="description">
                                <!-- Lorem ipsum dolor sit amet consectetur
                                adipisicing elit. Placeat excepturi odio
                                recusandae aliquid ad impedit autem commodi
                                earum voluptatem laboriosam? -->
                                {{products.detail }}
                            </p>
                        </div>

                        <div class="row questions bg-light p-3">
                            <div class="col-md-1 icon">
                                <i class="fa-brands fa-rocketchat questions-icon"></i>
                            </div>
                            <div class="col-md-11 text">
                                Have a question about our products at E-Store?
                                Feel free to contact our representatives via
                                live chat or email.
                            </div>
                        </div>

                        <div class="delivery my-4">
                            <p class="font-weight-bold mb-0">
                                <span><i class="fa-solid fa-truck"></i></span>
                                <b>Delivery done in 3 days from date of
                                    purchase</b>
                            </p>
                            <p class="text-secondary">
                                Order now to get this product delivery
                            </p>
                        </div>
                        <div class="delivery-options my-4">
                            <p class="font-weight-bold mb-0">
                                <span><i class="fa-solid fa-filter"></i></span>
                                <b>Delivery options</b>
                            </p>
                            <p class="text-secondary">
                                View delivery options here
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container similar-products my-4">
                <hr />
                <p class="display-5">Similar Products</p>

                <div class="row">
                    <div class="col-md-3">
                        <div class="similar-product">
                            <img class="w-100" src="https://source.unsplash.com/gsKdPcIyeGg" alt="Preview" />
                            <p class="title">Lovely black dress</p>
                            <p class="price">$100</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="similar-product">
                            <img class="w-100" src="https://source.unsplash.com/sg_gRhbYXhc" alt="Preview" />
                            <p class="title">Lovely Dress with patterns</p>
                            <p class="price">$85</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="similar-product">
                            <img class="w-100" src="https://source.unsplash.com/gJZQcirK8aw" alt="Preview" />
                            <p class="title">Lovely fashion dress</p>
                            <p class="price">$200</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="similar-product">
                            <img class="w-100" src="https://source.unsplash.com/qbB_Z2pXLEU" alt="Preview" />
                            <p class="title">Lovely red dress</p>
                            <p class="price">$120</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- blogs -->
        <section id="offers" class="py-5">
            <div class="container">
                <div
                    class="row d-flex align-items-center justify-content-center text-center justify-content-lg-start text-lg-start">
                    <div class="offers-content">
                        <span class="text-white">Discount Up To 40%</span>
                        <h2 class="mt-2 mb-4 text-white">Grand Sale Offer!</h2>
                        <a href="#" class="btn">Buy Now</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of blogs -->

        <!-- newsletter -->
        <section id="newsletter" class="py-5">
            <div class="container">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div class="title text-center pt-3 pb-5">
                        <h2 class="position-relative d-inline-block ms-4">
                            Inspiration Quote
                        </h2>
                    </div>

                    <p class="text-center text-muted">
                        "Sự tuân thủ là tội ác thực sự đối với thời trang. 
                        Lựa chọn không mặc theo cá tính của chính mình mà bán rẻ linh hồn để giống hệt một nhóm người chính là hành động đầu hàng trước chủ nghĩa phát-xít của thời trang." - Simon Doonan
                    </p>
                </div>
            </div>
        </section>
        <!-- end of newsletter -->

        <footer_fashion></footer_fashion>
    </div>
</template>


<script>
import navbar_fashion from "../../fashion_store/NavbarFashion.vue";
import footer_fashion from "../../fashion_store/FooterFashion.vue";
import index from "../../Sidenav/index.vue";

export default {
    name: "productDetail",
    data() {
        return {
            products: [],
            imageUrl: null,
            order: {
                user_id: '',
                status: "pending",
                products: [

                ],
            },
            descriptionImages: [],
            sizes: [],

            size: {
                id: '',
                name: '',
            },

        };
    },
    components: {
        navbar_fashion,
        index,
        footer_fashion,
    },



    created() {
        this.getProducts();
        this.getSizes();
        this.getDescriptionImages(),

        this.$store.state.showSidenav = false;
    },

    computed: {
    // Lọc danh sách description_images để chỉ bao gồm những hình ảnh có product_id khớp với products.id
    filteredDescriptionImages() {
        return this.descriptionImages.filter(
            (image) => image.product_id === this.products.id
        );
    },
},

    methods: {

        getDescriptionImages() {
            axios.get('/api/descriptionImages')
                .then(response => {
                    this.descriptionImages = response.data;
                    console.log(this.descriptionImages); // Kiểm tra dữ liệu
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getSizeName(sizeId) {
            const size = this.sizes.find(size => size.id === sizeId);
            return size ? size.name : 'Unknown'; // Trả về tên kích thước hoặc 'Unknown' nếu không tìm thấy
        },

        getSizes() {
            axios.get('/api/sizes')
                .then(response => {
                    this.sizes = response.data;
                    console.log(this.sizes); // Kiểm tra dữ liệu
                })
                .catch(error => {
                    console.log(error);
                });
        },

        getProducts() {
            axios
                .get(`/api/products/${this.$route.params.id}`)
                .then((response) => {
                    this.products = response.data;
                    console.log(this.products);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        addToCart() {
            // Tạo đối tượng sản phẩm từ dữ liệu sản phẩm hiện tại
            const productToAdd = {
                id: this.products.id,
                name: this.products.name,
                price: this.products.sell_price,
                image: this.products.image,
                size_id: this.products.size_id,
                quantity: 1 // Số lượng sản phẩm mặc định
            };

            // Gọi action addToCart để thêm sản phẩm vào giỏ hàng
            this.$store.dispatch('addToCart', productToAdd);
            alert('Product Added To Cart Succesfully');
            console.log(productToAdd);
        },
    },
};
</script>

<style>
.productDetail {
    .text-bold {
        font-weight: 800;
    }

    text-color {
        color: #0093c4;
    }

    /* Main image - left */
    .main-img img {
        width: 100%;
    }

    /* Preview images */
    .previews img {
        width: 80%;
        height: 140px;
    }

    .main-description .category {
        text-transform: uppercase;
        color: #0093c4;
    }

    .main-description .product-title {
        font-size: 2.5rem;
    }

    .old-price-discount {
        font-weight: 600;
    }

    .new-price {
        font-size: 2rem;
    }

    .details-title {
        text-transform: uppercase;
        font-weight: 600;
        font-size: 1.2rem;
        color: #757575;
    }

    .buttons .block {
        margin-right: 5px;
    }

    .quantity input {
        border-radius: 0;
        height: 40px;
    }

    .custom-btn {
        text-transform: capitalize;
        background-color: #0093c4;
        color: white;
        width: 150px;
        height: 40px;
        border-radius: 0;
    }

    .custom-btn:hover {
        background-color: #0093c4 !important;
        font-size: 18px;
        color: white !important;
    }

    .similar-product img {
        height: 400px;
    }

    .similar-product {
        text-align: left;
    }

    .similar-product .title {
        margin: 17px 0px 4px 0px;
    }

    .similar-product .price {
        font-weight: bold;
    }

    .questions .icon i {
        font-size: 2rem;
    }

    .questions-icon {
        font-size: 2rem;
        color: #0093c4;
    }

    /* Small devices (landscape phones, less than 768px) */
    @media (max-width: 767.98px) {

        /* Make preview images responsive  */
        .previews img {
            width: 100%;
            height: auto;
        }
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
    @media (min-width: 992px) {
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

    /* offers */
    #offers {
        background: url(../../fashion_store/images/lv_blog.jpg) center/cover no-repeat;
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
}
</style>
