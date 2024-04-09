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
import Dashboard from './Home/Dashboard.vue';
import FashionMainPage from './fashion_store/FashionMainPage.vue';
import YSLMainpage from './fashion_store/YSL/YSLMainpage.vue';
import LVMainPage from './fashion_store/LV/LVMainPage.vue';
import DataTablesTest from './components/DataTablesTest.vue';
import Orders from './Transactions/Orders.vue';
import ShoppingCart from './fashion_store/Cart/ShoppingCart.vue';
import ShopManagement from './ManagerStore/ShopManagement.vue';

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
    {
        name: 'profile',
        path: '/profile',
        component: Profile,
    },
    { 
        name: 'editProfile',
        path: '/users/:id/edit', 
        component: EditProfile 
    },
    {
        name: 'employeeList',
        path: '/employeeList',
        component: EmployeeList,
    },
    {
        name: 'employeeManagement',
        path: '/employeeManagement',
        component: EmployeeManagement,
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
        redirect: "/dashboard-default",
    },
    {
        name: 'dashboard',
        path: '/dashboard-default',
        component: Dashboard,
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
        name: 'dataTablesTest',
        path: '/dataTablesTest',
        component: DataTablesTest,
    },

    {
        name: 'orders',
        path: '/orders',
        component: Orders,
    },

    {
        name: 'shoppingCart',
        path: '/products/shoppingCart/:id/',
        component: ShoppingCart,
    },

    {
        name: 'shopManagement',
        path: '/shopManagement',
        component: ShopManagement,
    },
    

]




