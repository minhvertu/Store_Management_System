<template>
  <div class="collapse navbar-collapse w-auto h-auto h-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <sidenav-item url="/dashboard-default" :class="getRoute() === 'dashboard-default' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'لوحة القيادة' : 'Dashboard'">
          <template v-slot:icon>
            <!-- <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i> -->
            <span class="material-symbols-outlined">home</span>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item url="/task" :class="getRoute() === '/task' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'الجداول' : 'Task'">
          <template v-slot:icon>
            <!-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i> -->
            <span class="material-symbols-outlined">description</span>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item url="/users" :class="getRoute() === '/users' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'الفواتیر' : 'User'">
          <template v-slot:icon>
            <!-- <i class="ni ni-credit-card text-success text-sm opacity-10"></i> -->
            <span class="material-symbols-outlined">group</span>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item url="/virtual-reality" :class="getRoute() === 'virtual-reality' ? 'active' : ''" :navText="this.$store.state.isRTL ? 'الواقع الافتراضي' : 'Virtual Reality'
          ">
          <template v-slot:icon>
            <!-- <i class="ni ni-app text-info text-sm opacity-10"></i> -->
            <span class="material-symbols-outlined">bring_your_own_ip</span>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item url="/rtl-page" :class="getRoute() === 'rtl-page' ? 'active' : ''" navText="RTL">
          <template v-slot:icon>
            <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            <span class="material-symbols-outlined">sheets_rtl</span>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <span class="material-symbols-outlined">badge</span>
          {{ this.$store.state.isRTL ? 'اشتراك' : 'Employee' }}
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li>
            <sidenav-item url="/employeeList" :class="getRoute() === '/employeeList' ? 'active' : ''"
              :navText="this.$store.state.isRTL ? 'اشتراك' : 'EmployeeList'">
              <template v-slot:icon>
                <span class="material-symbols-outlined">patient_list</span>
              </template>
            </sidenav-item>
          </li>
          <li>
            <sidenav-item url="/" :class="getRoute() === '/' ? 'active' : ''"
              :navText="this.$store.state.isRTL ? 'اشتراك' : 'Log Out'" @click.prevent="logout">
              <template v-slot:icon>
                <span class="material-symbols-outlined">logout</span>
              </template>
            </sidenav-item>
          </li>
        </ul>
      </li>

      <li class="nav-item ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <span class="material-symbols-outlined">manage_accounts</span>
          {{ this.$store.state.isRTL ? 'اشتراك' : 'Account Setting' }}
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li>
            <sidenav-item url="/signup" :class="getRoute() === 'signup' ? 'active' : ''"
              :navText="this.$store.state.isRTL ? 'اشتراك' : 'Sign Up'">
              <template v-slot:icon>
                <span class="material-symbols-outlined">how_to_reg</span>
              </template>
            </sidenav-item>
          </li>
          <li>
            <sidenav-item url="/logout" :class="getRoute() === '/logout' ? 'active' : ''"
              :navText="this.$store.state.isRTL ? 'اشتراك' : 'Log Out'" @click.prevent="logout">
              <template v-slot:icon>
                <span class="material-symbols-outlined">logout</span>
              </template>
            </sidenav-item>
          </li>
          <li>
            <sidenav-item url="/profile" :class="getRoute() === '/profile' ? 'active' : ''"
              :navText="this.$store.state.isRTL ? 'حساب تعريفي' : 'Profile'">
              <template v-slot:icon>
                <!-- <i class="ni ni-single-02 text-dark text-sm opacity-10"></i> -->
                <span class="material-symbols-outlined">shield_person</span>
              </template>
            </sidenav-item>
          </li>
          <li>
            <sidenav-item url="/login" :class="getRoute() === '/login' ? 'active' : ''"
              :navText="this.$store.state.isRTL ? 'تسجيل الدخول' : 'Sign In'">
              <template v-slot:icon>
                <!-- <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i> -->
                <span class="material-symbols-outlined">login</span>
              </template>
            </sidenav-item>
          </li>
        </ul>
      </li>
    </ul>
  </div>
  <div class="pt-3 mx-3 mt-3 sidenav-footer">
    <sidenav-card :class="cardBg" textPrimary="Need Help?" textSecondary="Please check our docs" />
  </div>
</template>
<script>
import SidenavItem from "./SidenavItem.vue";
import SidenavCard from "./SidenavCard.vue";
import User from "../components/User.vue";
import Profile from "../Profile/Profile.vue";

export default {
  name: "SidenavList",
  props: {
    cardBg: String
  },
  data() {
    return {
      title: "Argon Dashboard 2",
      controls: "dashboardsExamples",
      isActive: "active"
    };
  },
  components: {
    SidenavItem,
    SidenavCard,
    User,
    Profile,
  },
  methods: {
    getRoute() {
      const routeArr = this.$route.path.split("/");
      return routeArr[1];
    },
    logout: function () {
      axios.post('/api/logout').then(response => {
        localStorage.removeItem('authToken');
        localStorage.removeItem('id');
        localStorage.removeItem('isLoggedIn');
        this.$router.push('/login');
      }).catch(error => {
        if (error.status === 302 || 401) {
          // document.location.href = '/login'
          this.$router.push('/login');
        }
        else {
          // throw error and go to catch block
        }
      })
    },
  }
};
</script>

<style></style>
