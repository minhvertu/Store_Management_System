<template>
  <div class="collapse navbar-collapse w-auto h-auto h-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <sidenav-item url="/dashboard-default" :class="getRoute() === 'dashboard-default' ? 'active' : ''"
          :navText="'Dashboard'">
          <template v-slot:icon>
            <span class="material-symbols-outlined">home</span>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item url="/task" :class="getRoute() === '/task' ? 'active' : ''" :navText="'Task'">

          <template v-slot:icon>
            <span class="material-symbols-outlined">description</span>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item url="/users" :class="getRoute() === '/users' ? 'active' : ''" :navText="'User'">

          <template v-slot:icon>
            <span class="material-symbols-outlined">group</span>
          </template>
        </sidenav-item>
      </li>

      <div v-if="roleId =='2'">
        <li class="nav-item">
          <a data-bs-toggle="dropdown" href="#applicationsExamples" class="nav-link dropdown-toggle"
            aria-controls="applicationsExamples" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <span class="material-symbols-outlined ">deployed_code</span>
            </div>
            <span class="nav-link-text ms-1">Products</span>
          </a>

          <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="">

        <li>
          <sidenav-item url="/employeeManagement" :class="getRoute() === '/employeeManagement' ? 'active' : ''"
            :navText="'PriceManagement'">

            <template v-slot:icon>
              <span class="material-symbols-outlined fa-lg">sell</span>
            </template>
          </sidenav-item>
        </li>
        <li>
          <sidenav-item url="/productList" :class="getRoute() === '/productList' ? 'active' : ''"
            :navText="'ProductList'">

            <template v-slot:icon>
              <span class="material-symbols-outlined fa-lg">view_list</span>
            </template>
          </sidenav-item>
        </li>
    </div>
    </li>
      </div>

  <div v-if="roleId =='2'">
    <li class="nav-item ">
      <a data-bs-toggle="dropdown" href="#applicationsExamples" class="nav-link dropdown-toggle"
        aria-controls="applicationsExamples" role="button" aria-expanded="false">
        <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
          <span class="material-symbols-outlined">badge</span>
        </div>
        <span class="nav-link-text ms-1">Employees</span>
      </a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li>
          <sidenav-item url="/employeeList" :class="getRoute() === '/employeeList' ? 'active' : ''"
            :navText="'EmployeeList'">

            <template v-slot:icon>
              <span class="material-symbols-outlined">patient_list</span>
            </template>
          </sidenav-item>
        </li>
        <li>
          <sidenav-item url="/employeeManagement" :class="getRoute() === '/employeeManagement' ? 'active' : ''"
            :navText="'EmployeeManagement'">

            <template v-slot:icon>
              <span class="material-symbols-outlined">patient_list</span>
            </template>
          </sidenav-item>
        </li>
        <li>
          <sidenav-item url="/" :class="getRoute() === '/' ? 'active' : ''" :navText="'Log Out'" @click.prevent="logout">

            <template v-slot:icon>
              <span class="material-symbols-outlined">logout</span>
            </template>
          </sidenav-item>
        </li>
      </ul>
    </li>
</div>

  <li class="nav-item ">
    <a data-bs-toggle="dropdown" href="#applicationsExamples" class="nav-link dropdown-toggle"
      aria-controls="applicationsExamples" role="button" aria-expanded="false">
      <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
        <span class="material-symbols-outlined">manage_accounts</span>
      </div>
      <span class="nav-link-text ms-1">Account Settings</span>
    </a>

    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      <li>
        <sidenav-item url="/signup" :class="getRoute() === 'signup' ? 'active' : ''" :navText="'Sign Up'">

          <template v-slot:icon>
            <span class="material-symbols-outlined">how_to_reg</span>
          </template>
        </sidenav-item>
      </li>
      <li>
        <sidenav-item url="/logout" :class="getRoute() === '/logout' ? 'active' : ''" :navText="'Log Out'"
          @click.prevent="logout">

          <template v-slot:icon>
            <span class="material-symbols-outlined">logout</span>
          </template>
        </sidenav-item>
      </li>
      <li>
        <sidenav-item url="/profile" :class="getRoute() === '/profile' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'حساب تعريفي' : 'Profile'">

          <template v-slot:icon>
            <span class="material-symbols-outlined">shield_person</span>
          </template>
        </sidenav-item>
      </li>
      <li>
        <sidenav-item url="/login" :class="getRoute() === '/login' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'تسجيل الدخول' : 'Sign In'">

          <template v-slot:icon>

            <span class="material-symbols-outlined">login</span>
          </template>
        </sidenav-item>
      </li>
    </ul>
  </li>

  <li class="nav-item ">
    <a data-bs-toggle="dropdown" href="#applicationsExamples" class="nav-link dropdown-toggle"
      aria-controls="applicationsExamples" role="button" aria-expanded="false">
      <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
        <span class="material-symbols-outlined">contract</span>
      </div>
      <span class="nav-link-text ms-1">Transactions</span>
    </a>

    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      <li>
        <sidenav-item url="/orders" :class="getRoute() === '/orders' ? 'active' : ''" :navText="'Orders'">

          <template v-slot:icon>
            <span class="material-symbols-outlined">orders</span>
          </template>
        </sidenav-item>
      </li>
      <li>
        <sidenav-item url="/importShipment" :class="getRoute() === '/importShipment' ? 'active' : ''"
          :navText="'ImportShipment'">

          <template v-slot:icon>
            <span class="material-symbols-outlined">
              local_shipping
            </span>
          </template>
        </sidenav-item>
      </li>

      <li>
        <sidenav-item url="/productPage" :class="getRoute() === '/productPage' ? 'active' : ''"
          :navText="'Purchase Products'">

          <template v-slot:icon>
            <span class="material-symbols-outlined">
              shopping_cart
            </span>
          </template>
        </sidenav-item>
      </li>


    </ul>
  </li>


  <li class="nav-item ">
    <a data-bs-toggle="dropdown" href="#applicationsExamples" class="nav-link dropdown-toggle"
      aria-controls="applicationsExamples" role="button" aria-expanded="false">
      <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
        <span class="material-symbols-outlined">store</span>
      </div>
      <span class="nav-link-text ms-1">Stores</span>
    </a>

    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      <li>
        <sidenav-item url="/shopManagement" :class="getRoute() === '/shopManagement' ? 'active' : ''"
          :navText="'Stock Check'">

          <template v-slot:icon>
            <span class="material-symbols-outlined">storefront</span>
          </template>
        </sidenav-item>
      </li>
      <li>
        <sidenav-item url="/login" :class="getRoute() === '/login' ? 'active' : ''" :navText="'Sign In'">
          <template v-slot:icon>
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
      isActive: "active",
      roleId: '',
    };
  },
  components: {
    SidenavItem,
    SidenavCard,
    User,
    Profile,
  },
  created() {
    this.roleId = localStorage.getItem('role_id');

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
        localStorage.removeItem('permission_id');
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
