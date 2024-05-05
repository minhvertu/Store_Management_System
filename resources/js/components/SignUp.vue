<template>
    <div class="container top-0 position-sticky z-index-sticky">
        <div class="row">
            <div class="col-12">
                <Navbar isBtn="bg-gradient-light" />
            </div>
        </div>
    </div>
    <main class="main-content mt-0">
        <div
            class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;"
        >
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                        <p class="text-lead text-white">Use these forms to create a new account in your project.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>Register</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="register">
                                <div class="mb-3">
        <input
            v-model="formData.name"
            type="text"
            placeholder="Name"
            aria-label="Name"
            class="form-control"
        />
    </div>

    <div class="mb-3">
        <input
            v-model="formData.email"
            type="email"
            placeholder="Email"
            aria-label="Email"
            class="form-control"
        />
    </div>

    <div class="mb-3">
        <input
            v-model="formData.password"
            type="password"
            placeholder="Password"
            aria-label="Password"
            class="form-control"
        />
    </div>
                                <ArgonCheckbox v-model="formData.agree">
                                    <label for="agreeCheckbox">
                                        I agree to the
                                        <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                                    </label>
                                </ArgonCheckbox>
                                <div class="text-center">
                                    <ArgonButton type="submit" fullWidth color="dark" variant="gradient" class="my-4 mb-2">
                                        Register
                                    </ArgonButton>
                                </div>
                                <p class="text-sm mt-3 mb-0">
                                    Already have an account?
                                    <router-link to="/login" class="text-dark font-weight-bolder">Sign in</router-link>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <AppFooter />
</template>

<script>
import axios from 'axios';
import Navbar from "../PageLayout/Navbar.vue";
import AppFooter from "../PageLayout/Footer.vue";
import ArgonInput from "../Profile/ArgonInput.vue";
import ArgonCheckbox from "../Profile/ArgonCheckbox.vue";
import ArgonButton from "../Profile/ArgonButton.vue";

export default {
    name: "RegisterPage",
    components: {
        Navbar,
        AppFooter,
        ArgonInput,
        ArgonCheckbox,
        ArgonButton,
    },
    data() {
        return {
            formData: {
                name: '',
                email: '',
                password: '',
                agree: true, // Trạng thái đồng ý với điều khoản và điều kiện
            },
        };
    },
    methods: {
        async register() {
            // Kiểm tra nếu người dùng đã đồng ý với điều khoản và điều kiện
            if (!this.formData.agree) {
                alert('You must agree to the Terms and Conditions');
                return;
            }

            try {
                // Gửi yêu cầu POST đến API /api/register với dữ liệu biểu mẫu
                console.log('Form data:', this.formData);
                const response = await axios.post('/api/register', {
                    name: this.formData.name,
                    email: this.formData.email,
                    password: this.formData.password,
                });

                // Xử lý phản hồi thành công
                const { token } = response.data.authorisation;

                // Lưu token vào localStorage
                localStorage.setItem('authToken', token);

                // Điều hướng người dùng đến trang khác (ví dụ: trang chủ)
                this.$router.push('/login');

                alert('Registration successful!');
            } catch (error) {
                // Xử lý lỗi
                console.error('Registration failed:', error);
                alert('Registration failed! Please try again.');
            }
        },
    },
    created() {
        // Cập nhật trạng thái ứng dụng
        this.$store.state.hideConfigButton = true;
        this.$store.state.showNavbar = false;
        this.$store.state.showSidenav = false;
        this.$store.state.showFooter = false;
    },
    beforeUnmount() {
        // Khôi phục trạng thái ứng dụng
        this.$store.state.hideConfigButton = false;
        this.$store.state.showNavbar = true;
        this.$store.state.showSidenav = true;
        this.$store.state.showFooter = true;
    }
};
</script>
