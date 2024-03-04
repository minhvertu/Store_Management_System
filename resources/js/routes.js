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
        name: 'NotFound',
        path: '/:pathMatch(.*)*',
        component: NotFoundPage,
    },
    {
        name: 'app',
        path: '/',
        component: App,
    },
    

]




