<template>
    <div class="navbar_fashion">
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top"> -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0" href="index.html">
                <img src="../fashion_store/images/Vertu-logo.jpg" alt="site icon" style="height:  20px;">
                <span class="text-uppercase fw-lighter ms-2 ">Vertu Phan</span>
            </a>

            <div class="order-lg-2 nav-btns">
                <router-link to="/shoppingCart">
                    <button type="button" class="btn position-relative">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-primary">5</span>
                    </button>
                 </router-link>
                <button type="button" class="btn position-relative">
                    <i class="fa fa-heart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-primary">2</span>
                </button>
                <button type="button" class="btn position-relative">
                    <i class="fa fa-search"></i>
                </button>
            </div>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-lg-1" id="navMenu">
                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item px-2 py-2">
                        <router-link to ="/fashion" class=" nav-link text-uppercase text-dark" href>home</router-link>
                    </li>
                    <li class="nav-item px-2 py-2">
                        <a class="nav-link text-uppercase text-dark" href="#collection">collection</a>
                    </li>
                    <li class="nav-item px-2 py-2">
                        <a class="nav-link text-uppercase text-dark" href="#special">specials</a>
                    </li>
                    <li class="nav-item px-2 py-2">
                        <a class="nav-link text-uppercase text-dark" href="#blogs">blogs</a>
                    </li>
                    <li class="nav-item px-2 py-2">
                        <a class="nav-link text-uppercase text-dark" href="#about">about us</a>
                    </li>
                    <li class="nav-item px-2 py-2 border-0">
                        <a class="nav-link text-uppercase text-dark" href="#popular">popular</a>
                    </li>
                    <li class="nav-item dropdown px-2 py-2">
    <a class="nav-link text-uppercase text-dark" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        account
    </a>
    <ul class="dropdown-menu" aria-labelledby="accountDropdown">

        <li>
            <router-link to="/login" class="dropdown-item">Login</router-link>
        </li>

        <li>
            <router-link to="/signUp" class="dropdown-item">Sign Up</router-link>
        </li>
        
        <li>
            <router-link to="/loginShop" class="dropdown-item">Shop</router-link>
        </li>

        <li>
            <a @click.prevent="logout" class="dropdown-item">Log Out</a>
        </li>
        <!-- Bạn có thể thêm các mục khác ở đây nếu cần -->
    </ul>
</li>
<li class="nav-item px-2 py-2 border-0">
    <router-link to="/clientProfile" class="nav-link text-uppercase text-dark" href="#popular">Profile</router-link>
</li>
                </ul>
            </div>
        </div>
    </nav>
</div>

</template>


<script>
 export default {
    name: "navbar_fashion",

    methods: {
        logout: function () {
      axios.post('/api/logout').then(response => {
        localStorage.removeItem('authToken');
        localStorage.removeItem('id');
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('permission_id');
        localStorage.removeItem('role_id');
        localStorage.removeItem('shop_id');
        this.$router.push('/loginShop');
      }).catch(error => {
        if (error.status === 302 || 401) {
          // document.location.href = '/login'
          this.$router.push('/loginShop');
        }
        else {
          // throw error and go to catch block
        }
      })
    },
    },
 }

</script>

<style>
.navbar_fashion {

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

    /* Quy tắc cho dropdown-menu */
.dropdown-menu {
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
    background-color: #f8f9fa; /* Màu nền phù hợp với trang */
}

/* Quy tắc cho dropdown-item */
.dropdown-item {
    padding: 8px 15px;
    color: #333;
    transition: background-color 0.3s, color 0.3s;
}

/* Hiệu ứng khi di chuột qua dropdown-item */
.dropdown-item:hover {
    background-color: var(--pink); /* Thay đổi màu nền khi di chuột */
    color: #fff;
}
}

</style>
