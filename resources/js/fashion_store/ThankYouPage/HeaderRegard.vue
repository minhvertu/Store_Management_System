<template>

    <header id = "headerRegard" class = "vh-100 carousel slide" data-bs-ride = "carousel" style = "padding-top: 104px;">
        <div class = "container h-100 d-flex align-items-center carousel-inner">
            <div class = "text-center carousel-item active">
                <!-- <h2 class = "text-capitalize text-white">Thank You For Choosing Our Services</h2> -->
                <h1 class = "text-uppercase py-2 fw-bold text-white">Thank You For Choosing Our Services</h1>
                <router-link to="/fashion"><a  class = "btn mt-3 text-uppercase">Back To Shopping</a></router-link>
            </div>

        </div>


    </header>

    </template>

    <script>
    export default {
        name: "header_regard",
     }

    </script>

    <style>


/* header */
#headerRegard {
    background: url(../../fashion_store/images/background_banner.jpg) top/cover no-repeat;
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

</style>

