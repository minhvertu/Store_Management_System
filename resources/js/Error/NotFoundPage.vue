<template>
    <div class="d-flex align-items-center justify-content-center vh-100">
      <div class="text-center">
        <h1 class="display-1 fw-bold">404</h1>
        <p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>
        <p class="lead">The page you’re looking for doesn’t exist.</p>
        <router-link :to="role_id == '3' || !role_id ? '/fashion' : '/dashboard-default'">
            <a class="btn btn-primary">Go Home</a>
        </router-link>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        role_id: '' // Khởi tạo role_id
      };
    },
    created() {
      // Lấy role_id từ localStorage và gán cho role_id
      this.role_id = localStorage.getItem('role_id');
      console.log(this.role_id);
      this.$store.state.showSidenav = false;
      this.$store.state.showNavbar = false;
      this.$store.state.showFooter = false;
      this.getUsers();
    },
    beforeUnmount() {
      this.$store.state.showSidenav = true;
      this.$store.state.showNavbar = true;
      this.$store.state.showFooter = true;
    },
    methods: {
      getUsers() {
        axios.get('api/users')
          .then(response => {
            this.users = response.data;
          })
          .catch(error => {
            console.log(error);
          });
      },
    }
  };
  </script>
