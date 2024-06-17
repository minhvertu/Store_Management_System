import ExampleComponent from './components/ExampleComponent.vue';


import User from './components/User.vue';
import Task from './components/Task.vue';
import Login from './components/Login.vue';
import Profile from './Profile/Profile.vue';
import EditProfile from './Profile/EditProfile.vue';
import EmployeeList from './Employee/EmployeeList.vue';
import EmployeeManagement from './Employee/EmployeeManagement.vue';
import EditEmployee from './Employee/EditEmployee.vue';
import ProductList from './Products/ProductList.vue';
import EditProduct from './Products/EditProduct.vue';
import NotFoundPage from './Error/NotFoundPage.vue';
import App from './components/App.vue';
import SignUp from './components/SignUp.vue';
import LoginShop from './components/LoginShop.vue';
import AdminPermissions from './components/AdminPermissions.vue';
import UserRoles from './components/UserRoles.vue';
import Dashboard from './Home/Dashboard.vue';
import FashionMainPage from './fashion_store/FashionMainPage.vue';
import YSLMainpage from './fashion_store/YSL/YSLMainpage.vue';
import LVMainPage from './fashion_store/LV/LVMainPage.vue';
import GucciMainpage from './fashion_store/Gucci/GucciMainpage.vue';
import ChanelMainpage from './fashion_store/Chanel/ChanelMainPage.vue';
import ZaraMainpage from './fashion_store/Zara/ZaraMainPage.vue';
import DolceMainpage from './fashion_store/Dolce/DolceMainPage.vue';
import PradaMainpage from './fashion_store/Prada/PradaMainPage.vue';
import CalvinKleinMainpage from './fashion_store/CalvinKlein/CalvinKleinMainPage.vue';
import UserManagement from './components/UserManagement.vue';
import Orders from './Transactions/Orders.vue';
import ProductDetail from './fashion_store/Cart/ProductDetail.vue';
import ShopManagement from './ManagerStore/ShopManagement.vue';
import ShoppingCart from './fashion_store/Cart/ShoppingCart.vue';
import ThankYouPage from './fashion_store/ThankYouPage/ThankYouPage.vue';
import ImportShipment from './Transactions/ImportShipment.vue';
import SellProducts from './Transactions/SellProducts.vue';
import InvoiceTest from  './Transactions/InvoiceTest.vue';
import ShopDetail from './Transactions/ShopDetail.vue';
import ProductPage from './Transactions/ProductPage.vue';
import ProductDetailOffline from './Transactions/ProductDetailOffline.vue';
import ClientProfile from './fashion_store/ClientProfile/ClientProfile.vue';

import FashionBlog from './fashion_store/FashionBlog/FashionBlog.vue';

import Profile2 from './Profile/Profile2.vue';




const getUserRole = () => {
    // Lấy dữ liệu từ localStorage
    const userRole = localStorage.getItem('role_id');
    // Trả về vai trò của người dùng
    return userRole;
};

const isBranchManager = (to, from, next) => {
    // Thực hiện kiểm tra vai trò của người dùng
    const userRole = getUserRole();

    // Kiểm tra nếu người dùng có vai trò là admin
    if (userRole === '4' || userRole === '5') {
        next(); // Cho phép điều hướng tiếp theo
    } else {
        // Nếu người dùng không phải là admin, điều hướng về trang không tìm thấy hoặc trang khác
        next('/not-found');
    }
};

const isAdmin = (to, from, next) => {
    // Thực hiện kiểm tra vai trò của người dùng
    const userRole = getUserRole();

    // Kiểm tra nếu người dùng có vai trò là admin
    if (userRole === '4') {
        next(); // Cho phép điều hướng tiếp theo
    } else {
        // Nếu người dùng không phải là admin, điều hướng về trang không tìm thấy hoặc trang khác
        next('/not-found');
    }
};

const isEmployee = (to, from, next) => {
    // Thực hiện kiểm tra vai trò của người dùng
    const userRole = getUserRole();

    // Kiểm tra nếu người dùng có vai trò là admin
    if (userRole === '1' || userRole === '4' || userRole === '2' || userRole === '5') {
        next(); // Cho phép điều hướng tiếp theo
    } else {
        // Nếu người dùng không phải là admin, điều hướng về trang không tìm thấy hoặc trang khác
        next('/not-found');
    }
};

// Khai báo hàm middleware kiểm tra vai trò của người dùng
const isManager = (to, from, next) => {
    // Thực hiện kiểm tra vai trò của người dùng
    const userRole = getUserRole();

    // Kiểm tra nếu người dùng có vai trò là admin hoặc manager
    if (userRole === '4' || userRole === '2' || userRole === '5') {
        next(); // Cho phép điều hướng tiếp theo
    } else {
        // Nếu người dùng không phải là admin hoặc manager, điều hướng về trang không tìm thấy hoặc trang khác
        next('/not-found');
    }
};


export const routes = [
    {
        name: ExampleComponent,
        path: '/home',
        component: ExampleComponent,
    },
    {
        name: 'user',
        path: '/users',
        component: User,
        beforeEnter: isAdmin,
    },
    {
        name: 'task',
        path: '/task',
        component: Task,
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
    },



    {
        name: 'signup',
        path: '/signup',
        component: SignUp,
    },
    // {
    //     name: 'profile',
    //     path: '/profile',
    //     component: Profile,
    // },
    {
        name: 'editProfile',
        path: '/users/:id/edit',
        component: EditProfile
    },
    {
        name: 'employeeList',
        path: '/employeeList',
        component: EmployeeList,
        beforeEnter: isManager,
    },
    {
        name: 'employeeManagement',
        path: '/employeeManagement',
        component: EmployeeManagement,
        beforeEnter: isManager,
    },
    {
        name: 'editEmployee',
        path: '/employees/:id/edit',
        component: EditEmployee,
    },
    {
        name: 'createEmployee',
        path: '/employees/create',
        component: EditEmployee,

    },
    {
        name: 'productList',
        path: '/productList',
        component: ProductList,
        beforeEnter: isEmployee,
    },
    {
        name: 'createProduct',
        path: '/products/create',
        component: EditProduct,
    },
    {
        name: 'editProduct',
        path: '/products/:id/edit',
        component: EditProduct,
    },
    {
        name: 'NotFound',
        path: '/:pathMatch(.*)*',
        component: NotFoundPage,
    },
    {
        name: 'a/',
        path: '/',
        redirect: "/fashion",
    },
    {
        name: 'dashboard',
        path: '/dashboard-default',
        component: Dashboard,
        beforeEnter: isEmployee,
    },
    {
        name: 'fashion',
        path: '/fashion',
        component: FashionMainPage,
    },

    {
        name: 'yslMainPage',
        path: '/yslMainPage',
        component: YSLMainpage,
    },

    {
        name: 'lvMainPage',
        path: '/lvMainPage',
        component: LVMainPage,
    },

    {
        name: 'userManagement',
        path: '/userManagement',
        component: UserManagement,
    },

    {
        name: 'orders',
        path: '/orders',
        component: Orders,
        beforeEnter: isEmployee,
    },

    {
        name: 'productDetail',
        path: '/products/productDetail/:id/',
        component: ProductDetail,
    },

    {
        name: 'shopManagement',
        path: '/shopManagement',
        component: ShopManagement,
        beforeEnter: isEmployee,
    },

    {
        name: 'shoppingCart',
        path: '/shoppingCart',
        component: ShoppingCart,
    },

    {
        name: 'regards',
        path: '/regards',
        component: ThankYouPage,
    },

    {
        name: 'importShipment',
        path: '/importShipment',
        component: ImportShipment,
        beforeEnter: isEmployee,
    },

    {
        name: 'sellProducts',
        path: '/sellProducts',
        component: SellProducts,
    },

    {
        name: 'invoiceTest',
        path: '/invoiceTest',
        component: InvoiceTest,
    },

    {
        name: 'shopDetail',
        path: '/shopDetail',
        component: ShopDetail,
    },

    {
        name: 'productPage',
        path: '/ProductPage',
        component: ProductPage,
    },

    {
        name: 'gucciMainPage',
        path: '/gucciMainPage',
        component: GucciMainpage,
    },

    {
        name: 'chanelMainPage',
        path: '/chanelMainPage',
        component: ChanelMainpage,
    },

    {
        name: 'zaraMainPage',
        path: '/zaraMainPage',
        component: ZaraMainpage,
    },

    {
        name: 'dolceMainPage',
        path: '/dolceMainPage',
        component: DolceMainpage,
    },

    {
        name: 'pradaMainPage',
        path: '/pradaMainPage',
        component: PradaMainpage,
    },

    {
        name: 'calvinKleinMainPage',
        path: '/calvinKleinMainPage',
        component: CalvinKleinMainpage,
    },

    {
        name: 'loginShop',
        path: '/loginShop',
        component: LoginShop,
    },

    {
        name: 'clientProfile',
        path: '/clientProfile',
        component: ClientProfile,
    },

    {
        name: 'profile',
        path: '/profile',
        component: Profile2,
        beforeEnter: isEmployee,
    },

    {
        name: 'adminPermissions',
        path: '/adminPermissions',
        component: AdminPermissions,
        beforeEnter: isAdmin,
    },

    {
        name: 'userRoles',
        path: '/userRoles',
        component: UserRoles,
        beforeEnter: isAdmin,
    },

    {
        name: 'productDetailOffline',
        path: '/products/productDetailOffline/:id/',
        component: ProductDetailOffline,
        beforeEnter: isEmployee,
    },

    {
        name: 'fashionBlog',
        path: '/fashionBlog',
        component: FashionBlog,
    },


]




