<template>

<div class = "yslPage">

  
    <!-- navbar -->
    <navbar_fashion></navbar_fashion>
    <!-- end of navbar -->

    <!-- header -->
    <header_ysl></header_ysl>
    <!-- end of header -->


    <section id = "collection" class = "py-5">
        <div class = "container">
            <div class = "title text-center">
                <h2 class = "position-relative d-inline-block">New Collection</h2>
            </div>

            <div class = "row g-0">
                <div class = "d-flex flex-wrap justify-content-center mt-5 filter-button-group">
                    <button type = "button" class = "btn m-2 text-dark active-filter-btn" data-filter = "*">All</button>
                    <button type = "button" class = "btn m-2 text-dark" data-filter = ".best">Best Sellers</button>
                    <button type = "button" class = "btn m-2 text-dark" data-filter = ".feat">Featured</button>
                    <button type = "button" class = "btn m-2 text-dark" data-filter = ".new">New Arrival</button>
                </div>

                <div class = "collection-list mt-4 row gx-0 gy-3">
                    <div class = "col-md-6 col-lg-4 col-xl-3 p-2 best">
                        <div class = "collection-img position-relative">
                            <img src = "../../fashion_store/images/c_formal_gray_shirt.png" class = "w-100">
                            <span class = "position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                        </div>
                        <div class = "text-center">
                            <div class = "rating mt-3">
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            </div>
                            <p class = "text-capitalize my-1">gray shirt</p>
                            <span class = "fw-bold">$ 45.50</span>
                        </div>
                    </div>

                    <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                        <div class = "collection-img position-relative">
                            <img src = "../../fashion_store/images/c_pant_girl.png" class = "w-100">
                            <span class = "position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                        </div>
                        <div class = "text-center">
                            <div class = "rating mt-3">
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            </div>
                            <p class = "text-capitalize my-1">gray shirt</p>
                            <span class = "fw-bold">$ 45.50</span>
                        </div>
                    </div>

                    <div class = "col-md-6 col-lg-4 col-xl-3 p-2 new">
                        <div class = "collection-img position-relative">
                            <img src = "../../fashion_store/images/c_polo-shirt.png" class = "w-100">
                            <span class = "position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                        </div>
                        <div class = "text-center">
                            <div class = "rating mt-3">
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            </div>
                            <p class = "text-capitalize my-1">gray shirt</p>
                            <span class = "fw-bold">$ 45.50</span>
                        </div>
                    </div>

                    <div class = "col-md-6 col-lg-4 col-xl-3 p-2 best">
                        <div class = "collection-img position-relative">
                            <img src = "../../fashion_store/images/c_shirt-girl.png" class = "w-100">
                            <span class = "position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                        </div>
                        <div class = "text-center">
                            <div class = "rating mt-3">
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            </div>
                            <p class = "text-capitalize my-1">gray shirt</p>
                            <span class = "fw-bold">$ 45.50</span>
                        </div>
                    </div>

                    <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                        <div class = "collection-img position-relative">
                            <img src = "../../fashion_store/images/c_t-shirt_men.png" class = "w-100">
                            <span class = "position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                        </div>
                        <div class = "text-center">
                            <div class = "rating mt-3">
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            </div>
                            <p class = "text-capitalize my-1">gray shirt</p>
                            <span class = "fw-bold">$ 45.50</span>
                        </div>
                    </div>

                    <div class = "col-md-6 col-lg-4 col-xl-3 p-2 new">
                        <div class = "collection-img position-relative">
                            <img src = "../../fashion_store/images/c_tunic-shirt_girl.png" class = "w-100">
                            <span class = "position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                        </div>
                        <div class = "text-center">
                            <div class = "rating mt-3">
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            </div>
                            <p class = "text-capitalize my-1">gray shirt</p>
                            <span class = "fw-bold">$ 45.50</span>
                        </div>
                    </div>

                    <div class = "col-md-6 col-lg-4 col-xl-3 p-2 best">
                        <div class = "collection-img position-relative">
                            <img src = "../../fashion_store/images/c_undershirt.png" class = "w-100">
                            <span class = "position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                        </div>
                        <div class = "text-center">
                            <div class = "rating mt-3">
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            </div>
                            <p class = "text-capitalize my-1">gray shirt</p>
                            <span class = "fw-bold">$ 45.50</span>
                        </div>
                    </div>

                    <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                        <div class = "collection-img position-relative">
                            <img src = "../../fashion_store/images/c_western-shirt.png" class = "w-100">
                            <span class = "position-absolute bg-primary text-white d-flex align-items-center justify-content-center">sale</span>
                        </div>
                        <div class = "text-center">
                            <div class = "rating mt-3">
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                                <span class = "text-primary"><i class = "fas fa-star"></i></span>
                            </div>
                            <p class = "text-capitalize my-1">gray shirt</p>
                            <span class = "fw-bold">$ 45.50</span>
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
import navbar_fashion from '../../fashion_store/NavbarFashion.vue';
import header_ysl from '../../fashion_store/YSL/HeaderYSL.vue';
import footer_fashion from '../../fashion_store/FooterFashion.vue';

export default {
    name: "ysl_page",
    components: {
        navbar_fashion,
        header_ysl,
        footer_fashion,
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

.yslPage{
    
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

/* header */
#header {
    background: url(../../fashion_store/images/ysl_bg2.jpg) top/cover no-repeat;
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
}

</style>