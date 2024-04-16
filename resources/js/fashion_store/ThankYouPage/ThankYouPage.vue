<template>
    <div class="Regards">
        <navbar_fashion></navbar_fashion>

        <header_regard></header_regard>

        <footer_fashion></footer_fashion>
    </div>
</template>

<script>
import navbar_fashion from "../NavbarFashion.vue";
import header_fashion from "../HeaderFashion.vue";
import header_regard from '../ThankYouPage/HeaderRegard.vue';
import footer_fashion from "..//FooterFashion.vue";
import index from "../../Sidenav/index.vue";
import navbar from "../../Navbars/navbar.vue";

export default {
    name: "Regards",
    components: {
        navbar_fashion,
        header_fashion,
        footer_fashion,
        index,
        header_regard,
        navbar,
    },

    data() {
        return {};
    },

    created() {
        this.$store.state.showNavbar = false;
        this.$store.state.showSidenav = false;
    },
};
</script>

<style>

    .Regards {
        body {
        font-family: var(--sm-font);
    }
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
        .bg-dark {
            background-color: #212529 !important;
        }

        carousel-inner h1 {
        font-size: 60px;
        font-family: var(--lg-font);
    }

    .carousel-item .btn {
        border-color: #fff !important;
    }

    .carousel-item .btn:hover {
        border-color: var(--pink) !important;
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



    }
</style>
