<template>
    <div class="FashionMainPage">
        <!-- navbar -->
        <navbar_fashion></navbar_fashion>
        <!-- end of navbar -->

        <!-- header -->
        <header_fashion></header_fashion>
        <!-- end of header -->

        <!-- collection -->
        <section id="collection" class="py-5">
            <div class="container">
                <div class="title text-center">
                    <h2 class="brand-font position-relative d-inline-block">BRANDS</h2>
                </div>

                <div class="row g-0">

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                        <router-link to="/lvMainPage">
                            <transition name="fade" mode="out-in">
                        <div class="collection-img position-relative">
                            <img src="../fashion_store/images/lv.png" class="w-100">
                        </div>
                    </transition>
                        </router-link>

                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2 feat">
                        <router-link to="/yslMainPage">
                            <transition name="fade" mode="out-in">
                                <div class="collection-img position-relative">
                                    <img src="../fashion_store/images/ysl.png" class="w-100">
                                </div>
                            </transition>
                        </router-link>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2 new">
                        <router-link to="/gucciMainPage">
                            <transition name="fade" mode="out-in">
                                <div class="collection-img position-relative">
                                    <img src="../fashion_store/images/gucci2.jpg" class="w-100">
                                </div>
                            </transition>
                        </router-link>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                        <router-link to="/chanelMainPage">
                            <transition name="fade" mode="out-in">
                                <div class="collection-img position-relative">
                                    <img src="../fashion_store/images/chanel.jpg" class="w-100">

                                </div>
                            </transition>
                        </router-link>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                        <router-link to="/zaraMainPage">
                            <transition name="fade" mode="out-in">
                                <div class="collection-img position-relative">
                                    <img src="../fashion_store/images/zara.png" class="w-100">

                                </div>
                            </transition>
                        </router-link>

                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                        <router-link to="/dolceMainPage">
                            <transition name="fade" mode="out-in">
                                <div class="collection-img position-relative">
                                    <img src="../fashion_store/images/dolce.jpg" class="w-100">

                                </div>
                            </transition>
                        </router-link>

                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                        <router-link to="/pradaMainPage">
                            <transition name="fade" mode="out-in">
                                <div class="collection-img position-relative">
                                    <img src="../fashion_store/images/pra.png" class="w-100">

                                </div>
                            </transition>
                        </router-link>

                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                        <router-link to="/calvinKleinMainPage">
                            <transition name="fade" mode="out-in">
                                <div class="collection-img position-relative">
                                    <img src="../fashion_store/images/calvin.png" class="w-100">

                                </div>
                            </transition>
                        </router-link>

                    </div>
                    <div class="d-flex flex-wrap justify-content-center mt-5 filter-button-group">
                        <button type="button" class="btn m-2 text-dark active-filter-btn" data-filter="*">All</button>
                        <button type="button" class="btn m-2 text-dark" data-filter=".best">Best Sellers</button>
                        <button type="button" class="btn m-2 text-dark" data-filter=".feat">Featured</button>
                        <button type="button" class="btn m-2 text-dark" data-filter=".new">New Arrival</button>
                    </div>

                    <div class="collection-list mt-4 row gx-0 gy-3">
                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                            <div class="collection-img position-relative">
                                <img src="../fashion_store/images/c_formal_gray_shirt.png" class="w-100">
                                <span
                                    class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                            </div>
                            <div class="text-center">
                                <div class="rating mt-3">
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                </div>
                                <p class="text-capitalize my-1">gray shirt</p>
                                <span class="fw-bold">$ 45.50</span>
                            </div>
                        </div>

                        <template v-for="(product, index) in products" :key="'product-' + index">
                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 feat" >
                            <router-link :to="`/products/productDetail/${product.id}`">
                                <div class="collection-img position-relative">
                                    <img :src="'/storage/' + product.image" class="w-100">
                                    <span
                                        class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                                </div>
                            </router-link>
                            <div class="text-center">
                                <div class="rating mt-3">
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                </div>
                                <p class="text-capitalize my-1">{{product.name}}</p>
                                <span class="fw-bold">$ {{product.sell_price}}</span>
                            </div>
                        </div>
                    </template>

                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="collection-img position-relative">
                                <img src="../fashion_store/images/c_pant_girl.png" class="w-100">
                                <span
                                    class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                            </div>
                            <div class="text-center">
                                <div class="rating mt-3">
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                </div>
                                <p class="text-capitalize my-1">gray shirt</p>
                                <span class="fw-bold">$ 45.50</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 new">
                            <div class="collection-img position-relative">
                                <img src="../fashion_store/images/c_polo-shirt.png" class="w-100">
                                <span
                                    class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                            </div>
                            <div class="text-center">
                                <div class="rating mt-3">
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                </div>
                                <p class="text-capitalize my-1">gray shirt</p>
                                <span class="fw-bold">$ 45.50</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                            <div class="collection-img position-relative">
                                <img src="../fashion_store/images/c_shirt-girl.png" class="w-100">
                                <span
                                    class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                            </div>
                            <div class="text-center">
                                <div class="rating mt-3">
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                </div>
                                <p class="text-capitalize my-1">gray shirt</p>
                                <span class="fw-bold">$ 45.50</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="collection-img position-relative">
                                <img src="../fashion_store/images/c_t-shirt_men.png" class="w-100">
                                <span
                                    class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                            </div>
                            <div class="text-center">
                                <div class="rating mt-3">
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                </div>
                                <p class="text-capitalize my-1">gray shirt</p>
                                <span class="fw-bold">$ 45.50</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 new">
                            <div class="collection-img position-relative">
                                <img src="../fashion_store/images/c_tunic-shirt_girl.png" class="w-100">
                                <span
                                    class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                            </div>
                            <div class="text-center">
                                <div class="rating mt-3">
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                </div>
                                <p class="text-capitalize my-1">gray shirt</p>
                                <span class="fw-bold">$ 45.50</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                            <div class="collection-img position-relative">
                                <img src="../fashion_store/images/c_undershirt.png" class="w-100">
                                <span
                                    class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                            </div>
                            <div class="text-center">
                                <div class="rating mt-3">
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                </div>
                                <p class="text-capitalize my-1">gray shirt</p>
                                <span class="fw-bold">$ 45.50</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="collection-img position-relative">
                                <img src="../fashion_store/images/c_western-shirt.png" class="w-100">
                                <span
                                    class="position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                            </div>
                            <div class="text-center">
                                <div class="rating mt-3">
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                    <span class="text-primary"><i class="fas fa-star"></i></span>
                                </div>
                                <p class="text-capitalize my-1">gray shirt</p>
                                <span class="fw-bold">$ 45.50</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of collection -->

        <!-- special products -->
        <section id="special" class="py-5">
            <div class="container">
                <div class="title text-center py-5">
                    <h2 class="position-relative d-inline-block">Special Selection</h2>
                </div>

                <div class="special-list row g-0">
                    <div class="col-md-6 col-lg-4 col-xl-3 p-2">
                        <div class="special-img position-relative overflow-hidden">
                            <img src="../fashion_store/images/special_product_1.jpg" class="w-100">
                            <span
                                class="position-absolute d-flex align-items-center justify-content-center text-primary fs-4">
                                <i class="fas fa-heart"></i>
                            </span>
                        </div>
                        <div class="text-center">
                            <p class="text-capitalize mt-3 mb-1">gray shirt</p>
                            <span class="fw-bold d-block">$ 45.50</span>
                            <a href="#" class="btn btn-primary mt-3">Add to Cart</a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2">
                        <div class="special-img position-relative overflow-hidden">
                            <img src="../fashion_store/images/special_product_2.jpg" class="w-100">
                            <span
                                class="position-absolute d-flex align-items-center justify-content-center text-primary fs-4">
                                <i class="fas fa-heart"></i>
                            </span>
                        </div>
                        <div class="text-center">
                            <p class="text-capitalize mt-3 mb-1">gray shirt</p>
                            <span class="fw-bold d-block">$ 45.50</span>
                            <a href="#" class="btn btn-primary mt-3">Add to Cart</a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2">
                        <div class="special-img position-relative overflow-hidden">
                            <img src="../fashion_store/images/special_product_3.jpg" class="w-100">
                            <span
                                class="position-absolute d-flex align-items-center justify-content-center text-primary fs-4">
                                <i class="fas fa-heart"></i>
                            </span>
                        </div>
                        <div class="text-center">
                            <p class="text-capitalize mt-3 mb-1">gray shirt</p>
                            <span class="fw-bold d-block">$ 45.50</span>
                            <a href="#" class="btn btn-primary mt-3">Add to Cart</a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 col-xl-3 p-2">
                        <div class="special-img position-relative overflow-hidden">
                            <img src="../fashion_store/images/special_product_4.jpg" class="w-100">
                            <span
                                class="position-absolute d-flex align-items-center justify-content-center text-primary fs-4">
                                <i class="fas fa-heart"></i>
                            </span>
                        </div>
                        <div class="text-center">
                            <p class="text-capitalize mt-3 mb-1">gray shirt</p>
                            <span class="fw-bold d-block">$ 45.50</span>
                            <a href="#" class="btn btn-primary mt-3">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of special products -->

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

        <!-- blogs -->
        <section id="blogs" class="py-5">
            <div class="container">
                <div class="title text-center py-5">
                    <h2 class="position-relative d-inline-block">Our Latest Blog</h2>
                </div>

                <div class="row g-3">
                    <div class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
                        <img src="../fashion_store/images/blog_1.jpg" alt="">
                        <div class="card-body px-0">
                            <h4 class="card-title">Lorem ipsum, dolor sit amet consectetur adipisicing</h4>
                            <p class="card-text mt-3 text-muted">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit.
                                Eveniet aspernatur repudiandae nostrum dolorem molestias odio. Sit fugit adipisci omnis
                                quia
                                itaque ratione iusto sapiente reiciendis, numquam officiis aliquid ipsam fuga.</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <span class="fw-bold">Author: </span>John Doe
                                </small>
                            </p>
                            <a href="#" class="btn">Read More</a>
                        </div>
                    </div>

                    <div class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
                        <img src="../fashion_store/images/blog_2.jpg" alt="">
                        <div class="card-body px-0">
                            <h4 class="card-title">Lorem ipsum, dolor sit amet consectetur adipisicing</h4>
                            <p class="card-text mt-3 text-muted">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit.
                                Eveniet aspernatur repudiandae nostrum dolorem molestias odio. Sit fugit adipisci omnis
                                quia
                                itaque ratione iusto sapiente reiciendis, numquam officiis aliquid ipsam fuga.</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <span class="fw-bold">Author: </span>John Doe
                                </small>
                            </p>
                            <a href="#" class="btn">Read More</a>
                        </div>
                    </div>

                    <div class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
                        <img src="../fashion_store/images/blog_3.jpg" alt="">
                        <div class="card-body px-0">
                            <h4 class="card-title">Lorem ipsum, dolor sit amet consectetur adipisicing</h4>
                            <p class="card-text mt-3 text-muted">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit.
                                Eveniet aspernatur repudiandae nostrum dolorem molestias odio. Sit fugit adipisci omnis
                                quia
                                itaque ratione iusto sapiente reiciendis, numquam officiis aliquid ipsam fuga.</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <span class="fw-bold">Author: </span>John Doe
                                </small>
                            </p>
                            <a href="#" class="btn">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of blogs -->

        <!-- about us -->
        <section id="about" class="py-5">
            <div class="container">
                <div class="row gy-lg-5 align-items-center">
                    <div class="col-lg-6 order-lg-1 text-center text-lg-start">
                        <div class="title pt-3 pb-5">
                            <h2 class="position-relative d-inline-block ms-4">About Us</h2>
                        </div>
                        <p class="lead text-muted">Tạo dấu ấn cá nhân với phong cách thời trang độc đáo và tinh tế
                        </p>
                        <p>Nâng tầm phong cách với những lựa chọn đẳng cấp và tinh tế.</p>
                    </div>
                    <div class="col-lg-6 order-lg-0">
                        <img src="../fashion_store/images/about_us_luxury.jpg" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>
        <!-- end of about us -->

        <!-- popular -->
        <section id="popular" class="py-5">
            <div class="container">
                <div class="title text-center pt-3 pb-5">
                    <h2 class="position-relative d-inline-block ms-4">Popular Of This Year</h2>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4 row g-3">
                        <h3 class="fs-5">Top Rated</h3>
                        <div class="d-flex align-items-start justify-content-start">
                            <img src="../fashion_store/images/top_rated_1.jpg" alt="" class="img-fluid pe-3 w-25">
                            <div>
                                <p class="mb-0">Blue Shirt</p>
                                <span>$ 20.00</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-start">
                            <img src="../fashion_store/images/top_rated_2.jpg" alt="" class="img-fluid pe-3 w-25">
                            <div>
                                <p class="mb-0">Blue Shirt</p>
                                <span>$ 20.00</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-start">
                            <img src="../fashion_store/images/top_rated_3.jpg" alt="" class="img-fluid pe-3 w-25">
                            <div>
                                <p class="mb-0">Blue Shirt</p>
                                <span>$ 20.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 row g-3">
                        <h3 class="fs-5">Best Selling</h3>
                        <div class="d-flex align-items-start justify-content-start">
                            <img src="../fashion_store/images/best_selling_1.jpg" alt="" class="img-fluid pe-3 w-25">
                            <div>
                                <p class="mb-0">Blue Shirt</p>
                                <span>$ 20.00</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-start">
                            <img src="../fashion_store/images/best_selling_2.jpg" alt="" class="img-fluid pe-3 w-25">
                            <div>
                                <p class="mb-0">Blue Shirt</p>
                                <span>$ 20.00</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-start">
                            <img src="../fashion_store/images/best_selling_3.jpg" alt="" class="img-fluid pe-3 w-25">
                            <div>
                                <p class="mb-0">Blue Shirt</p>
                                <span>$ 20.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 row g-3">
                        <h3 class="fs-5">On Sale</h3>
                        <div class="d-flex align-items-start justify-content-start">
                            <img src="../fashion_store/images/on_sale_1.jpg" alt="" class="img-fluid pe-3 w-25">
                            <div>
                                <p class="mb-0">Blue Shirt</p>
                                <span>$ 20.00</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-start">
                            <img src="../fashion_store/images/on_sale_2.jpg" alt="" class="img-fluid pe-3 w-25">
                            <div>
                                <p class="mb-0">Blue Shirt</p>
                                <span>$ 20.00</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-start">
                            <img src="../fashion_store/images/on_sale_3.jpg" alt="" class="img-fluid pe-3 w-25">
                            <div>
                                <p class="mb-0">Blue Shirt</p>
                                <span>$ 20.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of popular -->

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

        <!-- footer -->
        <footer_fashion></footer_fashion>
        <!-- end of footer -->
    </div>

</template>

<script>

import navbar_fashion from '../fashion_store/NavbarFashion.vue';
import header_fashion from '../fashion_store/HeaderFashion.vue';
import footer_fashion from '../fashion_store/FooterFashion.vue';

export default {
    name: "FashionMain",
    components: {
        navbar_fashion,
        header_fashion,
        footer_fashion,
    },

    data() {
        return {
            products: [],
            product: {
                id: '',
                name: '',
                amount: '',
                product_type: '',
                sell_price: '',
                gender_item_code: '',
                size: '',
                brand_id: '',
                category_id: '',
                image: '',
            },
            storages: [],
            storage: {
                id: '',
                product_id: '',
                shop_id: '',
                size_id:'',

                amount: '',
            },
            product_size_amounts: [],
            product_size_amount: {
                id: '',
                amount: '',
                storage_id: '',
                size_id: '',

            },
            imageUrl: null,
        }
    },

    created() {
        this.getProducts();

    },

    methods: {

        getProducts() {
            axios.get('api/get1products')
                .then(response => {
                    this.products = response.data;
                    console.log(this.products);

                })
                .catch(error => {
                    console.log(error);
                });
        },

    },

}
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

.FashionMainPage {


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
    /* .navbar {
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
    } */



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

    /* header */
    /* #header {
        background: url(../fashion_store/images/chaubui2.jpg) top/cover no-repeat;
    }

    .carousel-inner h1 {
        font-size: 60px;
        font-family: var(--lg-font);
    }

    .carousel-item .btn {
        border-color: #fff !important;
    }

    .carousel-item .btn:hover {
        border-color: var(--pink) !important;
    } */

    /* offers */
    #offers {
        background: url(../fashion_store/images/tou.jpg) center/cover no-repeat;

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

    .fade-enter-active,

    .fade-leave-active {
        transition: opacity 0.3s;
    }
    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }
}
</style>
