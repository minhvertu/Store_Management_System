<template>

    <div class="shoppingCart">

        <navbar_fashion></navbar_fashion>

        <section id="collection" class="py-5">

            <div class="container ">
             
                <div class="row">
                    <div class="col-md-5">
                        <div class="main-img">
                            <img class="img-fluid"
                                :src="'/storage/' + product.image"
                                alt="ProductS">
                            <div class="row my-3 previews">
                                <div class="col-md-3">
                                    <img class="w-100"
                                        src="https://cdn.pixabay.com/photo/2015/07/24/18/40/model-858754_960_720.jpg"
                                        alt="Sale">
                                </div>
                                <div class="col-md-3">
                                    <img class="w-100"
                                        src="https://cdn.pixabay.com/photo/2015/07/24/18/38/model-858749_960_720.jpg"
                                        alt="Sale">
                                </div>
                                <div class="col-md-3">
                                    <img class="w-100"
                                        src="https://cdn.pixabay.com/photo/2015/07/24/18/39/model-858751_960_720.jpg"
                                        alt="Sale">
                                </div>
                                <div class="col-md-3">
                                    <img class="w-100"
                                        src="https://cdn.pixabay.com/photo/2015/07/24/18/37/model-858748_960_720.jpg"
                                        alt="Sale">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="main-description px-2">
                            <div class="category text-bold">
                                Category: Women
                            </div>
                            <div class="product-title text-bold my-3">
                                Black dress for Women
                            </div>


                            <div class="price-area my-4">
                                <p class="old-price mb-1"><del>$100</del> <span
                                        class="old-price-discount text-danger">(20% off)</span></p>
                                <p class="new-price text-bold mb-1">$80</p>
                                <p class="text-secondary mb-1">(Additional tax may apply on checkout)</p>

                            </div>


                            <div class="buttons d-flex my-5">
                                <div class="block">
                                    <a href="#" class="shadow btn custom-btn ">Wishlist</a>
                                </div>
                                <div class="block">
                                    <button class="shadow btn custom-btn">Add to cart</button>
                                </div>

                                <div class="block quantity">
                                    <input type="number" class="form-control" id="cart_quantity" value="1" min="0"
                                        max="5" placeholder="Enter email" name="cart_quantity">
                                </div>
                            </div>




                        </div>

                        <div class="product-details my-4">
                            <p class="details-title text-color mb-1">Product Details</p>
                            <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat
                                excepturi odio recusandae aliquid ad impedit autem commodi earum voluptatem laboriosam?
                            </p>
                        </div>

                        <div class="row questions bg-light p-3">
                            <div class="col-md-1 icon">
                                <i class="fa-brands fa-rocketchat questions-icon"></i>
                            </div>
                            <div class="col-md-11 text">
                                Have a question about our products at E-Store? Feel free to contact our representatives
                                via live chat or email.
                            </div>
                        </div>

                        <div class="delivery my-4">
                            <p class="font-weight-bold mb-0"><span><i class="fa-solid fa-truck"></i></span> <b>Delivery
                                    done in 3 days from date of purchase</b> </p>
                            <p class="text-secondary">Order now to get this product delivery</p>
                        </div>
                        <div class="delivery-options my-4">
                            <p class="font-weight-bold mb-0"><span><i class="fa-solid fa-filter"></i></span> <b>Delivery
                                    options</b> </p>
                            <p class="text-secondary">View delivery options here</p>
                        </div>

                    </div>
                </div>
            </div>



            <div class="container similar-products my-4">
                <hr>
                <p class="display-5">Similar Products</p>

                <div class="row">
                    <div class="col-md-3">
                        <div class="similar-product">
                            <img class="w-100" src="https://source.unsplash.com/gsKdPcIyeGg" alt="Preview">
                            <p class="title">Lovely black dress</p>
                            <p class="price">$100</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="similar-product">
                            <img class="w-100" src="https://source.unsplash.com/sg_gRhbYXhc" alt="Preview">
                            <p class="title">Lovely Dress with patterns</p>
                            <p class="price">$85</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="similar-product">
                            <img class="w-100" src="https://source.unsplash.com/gJZQcirK8aw" alt="Preview">
                            <p class="title">Lovely fashion dress</p>
                            <p class="price">$200</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="similar-product">
                            <img class="w-100" src="https://source.unsplash.com/qbB_Z2pXLEU" alt="Preview">
                            <p class="title">Lovely red dress</p>
                            <p class="price">$120</p>
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
import footer_fashion from '../../fashion_store/FooterFashion.vue';
import index from '../../Sidenav/index.vue';

export default {
    name: "shopping_cart",
    data() {
        return {
            product: [],
            imageUrl: null,
        }
    },
    components: {
        navbar_fashion,
        index,
    },

    created () {
        this.$store.state.showSidenav = false;
        this.getProducts();
    },

    methods: {
        getProducts() {
            axios.get(`/api/products/${this.$route.params.id}`)
                .then(response => {
                    this.product = response.data;
                    console.log(this.product);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getImage(product) {
            // Điền dữ liệu sản phẩm hiện tại vào biến editedProduct
            this.editedProduct = {
                id: product.id,
                name: product.name,
                amount: product.amount,
                import_price: product.import_price,
                sell_price: product.sell_price,
                gender_item_code: product.gender_item_code,
                size: product.size,
                brand_id: product.brand_id,
                category_id: product.category_id,
                image: product.image,
            };
          
        },

    },
    async mounted() {
        const response = await axios.get(`/api/products/${id}`);
        this.products = response.data;
        this.imageUrl = response.data.image;
    },

}

</script>

<style>
.shoppingCart 
{
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
    width: 100%;
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
