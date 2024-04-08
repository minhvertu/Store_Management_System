<template>
    
    <header id = "headerYSL" class = "vh-100 carousel slide" data-bs-ride = "carousel" style = "padding-top: 104px;">
        <div class = "container h-100 d-flex align-items-center carousel-inner">
            <div class = "text-center carousel-item active">
                <h2 class = "text-capitalize text-white">best collection</h2>
                <h1 class = "text-uppercase py-2 fw-bold text-white">new arrivals</h1>
                <a href="#collection" class = "btn mt-3 text-uppercase">shop now</a>
            </div>
            <div class = "text-center carousel-item">
                <h2 class = "text-capitalize text-white">best price & offer</h2>
                <h1 class = "text-uppercase py-2 fw-bold text-white">new season</h1>
                <a href = "#" class = "btn mt-3 text-uppercase">buy now</a>
            </div>
        </div>
    
        <button class = "carousel-control-prev" type = "button" data-bs-target="#headerYSL" data-bs-slide = "prev">
            <span class = "carousel-control-prev-icon"></span>
        </button>
        <button class = "carousel-control-next" type = "button" data-bs-target="#headerYSL" data-bs-slide = "next">
            <span class = "carousel-control-next-icon"></span>
        </button>
    </header>
    
    </template>
    
    <script>
    export default {
        name: "header_ysl",
     }
     
    </script>

    <style>


/* header */
#headerYSL {
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

</style>
    
    