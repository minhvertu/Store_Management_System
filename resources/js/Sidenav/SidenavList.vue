<template>
    <div class="collapse navbar-collapse w-auto h-auto h-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <!-- <div v-if="roleId == 1 || roleId == 2 || roleId == 3 || roleId == 5" > -->
        <li class="nav-item" @click="toggleDropdown('admin')">
          <sidenav-item url="/dashboard-default" :navText="'Dashboard'">
            <template v-slot:icon>
              <span class="material-symbols-outlined">home</span>
            </template>
          </sidenav-item>
        </li>
        <!-- </div> -->
        <div v-if="roleId == 4">
        <li class="nav-item">
          <div @click="toggleDropdown('admin')" class="nav-link dropdown-toggle" role="button">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <span class="material-symbols-outlined">admin_panel_settings</span>
            </div>
            <span class="nav-link-text ms-1">Admin</span>
          </div>
          <div class="dropdown-menu" :class="{ show: isDropdownOpen('admin') }">
            <li>
              <sidenav-item url="/adminPermissions" :navText="'User Permissions'">
                <template v-slot:icon>
                  <span class="material-symbols-outlined fa-lg">verified_user</span>
                </template>
              </sidenav-item>
            </li>
            <li>
              <sidenav-item url="/userRoles" :navText="'User Roles'">
                <template v-slot:icon>
                  <span class="material-symbols-outlined fa-lg">shield_person</span>
                </template>
              </sidenav-item>
            </li>
            <li>
              <sidenav-item url="/userManagement" :navText="'Users Management'">
                <template v-slot:icon>
                  <span class="material-symbols-outlined fa-lg">group</span>
                </template>
              </sidenav-item>
            </li>
          </div>
        </li>
    </div>
        <li class="nav-item">
          <sidenav-item url="/productList" :navText="'Products List'">
            <template v-slot:icon>
              <span class="material-symbols-outlined">deployed_code</span>
            </template>
          </sidenav-item>
        </li>
        <li class="nav-item" v-if="roleId == '2' || roleId == '4' || roleId == '5'">
          <sidenav-item url="/employeeManagement" :navText="'Employee Management'">
            <template v-slot:icon>
              <span class="material-symbols-outlined">patient_list</span>
            </template>
          </sidenav-item>
        </li>
        <li class="nav-item">
          <div @click="toggleDropdown('accountSettings')" class="nav-link dropdown-toggle" role="button">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <span class="material-symbols-outlined">manage_accounts</span>
            </div>
            <span class="nav-link-text ms-1">Account Settings</span>
          </div>
          <div class="dropdown-menu" :class="{ show: isDropdownOpen('accountSettings') }">
            <li>
              <sidenav-item url="/logout" :navText="'Log Out'" @click.prevent="logout">
                <template v-slot:icon>
                  <span class="material-symbols-outlined">logout</span>
                </template>
              </sidenav-item>
            </li>
            <li>
              <sidenav-item url="/profile" :navText="this.$store.state.isRTL ? 'حساب تعريفي' : 'Profile'">
                <template v-slot:icon>
                  <span class="material-symbols-outlined">shield_person</span>
                </template>
              </sidenav-item>
            </li>
          </div>
        </li>
        <li class="nav-item">
          <div @click="toggleDropdown('transactions')" class="nav-link dropdown-toggle" role="button">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <span class="material-symbols-outlined">contract</span>
            </div>
            <span class="nav-link-text ms-1">Transactions</span>
          </div>
          <div class="dropdown-menu" :class="{ show: isDropdownOpen('transactions') }">
            <li>
              <sidenav-item url="/orders" :navText="'Orders'">
                <template v-slot:icon>
                  <span class="material-symbols-outlined">orders</span>
                </template>
              </sidenav-item>
            </li>
            <li>
              <sidenav-item url="/importShipment" :navText="'ImportShipment'">
                <template v-slot:icon>
                  <span class="material-symbols-outlined">local_shipping</span>
                </template>
              </sidenav-item>
            </li>
            <li>
              <sidenav-item url="/productPage" :navText="'Purchase Products'">
                <template v-slot:icon>
                  <span class="material-symbols-outlined">shopping_cart</span>
                </template>
              </sidenav-item>
            </li>
          </div>
        </li>
        <li class="nav-item">
          <div @click="toggleDropdown('stores')" class="nav-link dropdown-toggle" role="button">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <span class="material-symbols-outlined">store</span>
            </div>
            <span class="nav-link-text ms-1">Stores</span>
          </div>
          <div class="dropdown-menu" :class="{ show: isDropdownOpen('stores') }">
            <li>
              <sidenav-item url="/shopManagement" :navText="'Stock Check'">
                <template v-slot:icon>
                  <span class="material-symbols-outlined">storefront</span>
                </template>
              </sidenav-item>
            </li>
          </div>
        </li>
      </ul>
    </div>
  </template>


<script>
import axios from 'axios';
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
      roleId: '',
      openDropdown: null, // Biến để xác định dropdown nào đang mở
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
    toggleDropdown(dropdownName) {
      if (this.openDropdown === dropdownName) {
        this.openDropdown = null; // Đóng dropdown nếu nó đang mở
      } else {
        this.openDropdown = dropdownName; // Mở dropdown khi được nhấn
      }
    },
    isDropdownOpen(dropdownName) {
      return this.openDropdown === dropdownName;
    },
    logout() {
      axios.post('/api/logout')
        .then(response => {
          localStorage.removeItem('authToken');
          localStorage.removeItem('id');
          localStorage.removeItem('isLoggedIn');
          localStorage.removeItem('permission_id');
          localStorage.removeItem('role_id');
          localStorage.removeItem('shop_id');
          this.$router.push('/login');
        })
        .catch(error => {
          if (error.status === 302 || error.status === 401) {
            this.$router.push('/login');
          } else {
            // Xử lý các lỗi khác
          }
        });
    },
  }
};
</script>

<style scoped>
.nav-link.active {
  font-weight: bold;
}
.dropdown-menu {
  display: none;
}
.dropdown-menu.show {
  display: block;
}
</style>
