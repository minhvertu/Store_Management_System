import ExampleComponent from './components/ExampleComponent.vue';


import User from './components/User.vue';
import Task from './components/Task.vue';
import Login from './components/Login.vue';
import Profile from './Profile/Profile.vue';
import EditProfile from './Profile/EditProfile.vue';
import EmployeeList from './Employee/EmployeeList.vue';
import NotFoundPage from './Error/NotFoundPage.vue';
import App from './components/App.vue';

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




