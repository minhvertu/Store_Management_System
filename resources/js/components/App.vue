<template>
  <div class="app">
    <div v-show="this.$store.state.layout === 'landing'"
      class="landing-bg h-100 bg-gradient-primary position-fixed w-100"></div>
    <index :custom_class="this.$store.state.mcolor" :class="[
      this.$store.state.isTransparent,
      this.$store.state.isRTL ? 'fixed-end' : 'fixed-start'
    ]" v-if="this.$store.state.showSidenav" />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import { useRouter } from 'vue-router';
import index from "../Sidenav/index.vue";
import Login from './Login.vue';

export default {
  name: "App",
  components: {
    index,
  },
  data() {
    return {
      loaded: false, // Biến đánh dấu trang đã được load
    };
  },
  computed: {
    isLoggedIn() {
      return this.$store.getters['auth/isLoggedIn'];
    },
  },
  created() {
    const token = localStorage.getItem('authToken');
    const isLoggedIn = localStorage.getItem('isLoggedIn');
    const id = localStorage.getItem('id');
    if (!isLoggedIn || isLoggedIn !== 'true' || id == null) {
      this.$router.push('/login');
    } else {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
      this.loaded = true; // Đánh dấu trang đã được load
    }
    window.addEventListener('beforeunload', this.clearLocalStorageOnClose);
    window.addEventListener('load', this.setLoadedFlag);
  },
  beforeUnmount() {
    window.removeEventListener('beforeunload', this.clearLocalStorageOnClose);
  },
  methods: {
    checkLogin() {
      if (this.loaded && this.isLoggedIn) {
        this.$router.push('/');
      }
    },
    clearLocalStorageOnClose(event) {
      // Kiểm tra nếu trang không được làm mới và không có action là /login
      if (!this.loaded && this.$route.path !== '/login') {
        if (this.isLoggedIn) {
          // Đăng nhập, không xóa localStorage khi đóng tab
          return;
        }
        // Người dùng không đăng nhập, xóa toàn bộ localStorage
        localStorage.clear();
      }
    },
    setLoadedFlag() {
      this.loaded = true; // Đánh dấu trang đã được load
    },
  }
}


</script>

<style lang="scss" >
.container {
  margin-top: 50px;

  .user-login {
    text-align: right;
  }

  .main-content {
    margin-top: 50px;
  }
}

:root {
  --primary: #4ade80;
  --primary-alt: #22c55e;
  --grey: #64748b;
  --dark: #1e293b;
  --dark-alt: #334155;
  --light: #f1f5f9;
  --sidebar-width: 200px;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Fira sans', sans-serif;
}

body {
  background: var(--light);
}

button {
  cursor: pointer;
  appearance: none;
  border: none;
  outline: none;
  background: none;
}

.app {
  display: flex;

  main {
    flex: 1 1 0;
    padding: 0.25rem;

    @media (max-width: 1024px) {
      padding-left: 20rem;
    }
  }
}
</style>
