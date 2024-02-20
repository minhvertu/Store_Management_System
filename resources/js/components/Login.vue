<template>
 <!-- <main id = "Login">
    <div class="row">
      <div class="col-sm-4">
        <h2 align="center">Login</h2>
        <form @submit.prevent="loginUser">
          <div class="form-group" align="left">
            <label>Email</label>
            <input type="email" v-model="user.email" class="form-control" placeholder="Email" required>
          </div>
          <div class="form-group" align="left">
            <label>Password</label>
            <input type="password" v-model="user.password" class="form-control" placeholder="Password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </main> -->
  <div class="container top-0 position-sticky z-index-sticky">
    <div class="row">
      <div class="col-12">
        <navbar
          isBlur="blur  border-radius-lg my-3 py-2 start-0 end-0 mx-4 shadow"
          v-bind:darkMode="true"
          isBtn="bg-gradient-success"
        />
      </div>
    </div>
  </div>
  <main class="mt-0 main-content">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="mx-auto col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0">
              <div class="card card-plain">
                <div class="pb-0 card-header text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">
                    <form @submit.prevent="loginUser">

                    <div class="mb-3">
                        <input type="email" v-model="user.email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" v-model="user.password" class="form-control" placeholder="Password" required>
                    </div>
                    <argon-switch id="rememberMe">Remember me</argon-switch>

                    <div class="text-center">
                      <!-- <argon-button
                        class="mt-4"
                        variant="gradient"
                        color="success"
                        fullWidth
                        size="lg"
                      >Sign in</argon-button> -->
                      <button type="submit" class="btn btn-primary">Login</button>
                    </div>

                </form>
                </div>
                <div class="px-1 pt-0 text-center card-footer px-lg-2">
                  <p class="mx-auto mb-4 text-sm">
                    Don't have an account?
                    <a
                      href="/signup"
                      class="text-success text-gradient font-weight-bold"
                    >Sign up</a>
                  </p>
                </div>
              </div>
            </div>
            <div
              class="top-0 my-auto text-center col-6 d-lg-flex d-none h-100 pe-0 position-absolute end-0 justify-content-center flex-column"
            >
              <div
                class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
          background-size: cover;"
              >
                <span class="mask bg-gradient-success opacity-6"></span>
                <h4
                  class="mt-5 text-white font-weight-bolder position-relative"
                >"Attention is the new currency"</h4>
                <p
                  class="text-white position-relative"
                >The more effortless the writing looks, the more effort the writer actually put into the process.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import axios from 'axios';

import { reactive } from 'vue';
import { useRouter } from 'vue-router';
import index from '../Sidenav/index.vue';
import ArgonInput from "../Profile/ArgonInput.vue";
import ArgonSwitch from "../Profile/ArgonSwitch.vue";
import ArgonButton from "../Profile/ArgonButton.vue";



export default {
  name: 'Login',
  components: {
    index,
    ArgonInput,
    ArgonSwitch,
    ArgonButton,
  },
  data() {
    return {
      user: {
        email: '',
        password: '',
      },
    };
  },
  created() {
    this.$store.state.showSidenav = false;
  },

  beforeUnmount() {
    this.$store.state.showSidenav = true;
  },
  methods: {
    loginUser() {
      axios.post('/api/login', this.user)
        .then(({ data }) => {
          console.log(data);
          try {
            if (data.status === 'success') {
              alert('Login Successfully');

              axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.authorisation.token;
              localStorage.setItem('authToken', data.authorisation.token);
              localStorage.setItem('id', data.user.id);
              localStorage.setItem('isLoggedIn', true);

              this.$router.push('/');
            } else {
              alert('Login failed');
            }
          } catch (err) {
            alert('Error, please try again');
          }
        })
        .catch(error => {
          console.error(error);
          alert('An error occurred, please try again');
        });
    },
  },
};
</script>
