<template>
    <div class="container">
        <div class="user-login">
            <div class="username">
                <!-- User: {{ $root.user.name }} -->
            </div>
            <div class="logout">
                <a href="#" @click.prevent="logout">Logout</a>
            </div>
        </div>
        <div>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <router-link exact class="nav-link" to="/task">Tasks</router-link>
                </li>
                <li class="nav-item">
                    <router-link exact class="nav-link" to="/users">Users</router-link>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { useRouter } from 'vue-router';
    export default {
        methods: {
            logout:function(){
                axios.post('/api/logout').then(response => {
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
    }
</script>

<style lang="scss" scoped>
    .container {
        margin-top: 50px;
        .user-login {
            text-align: right;
        }
        .main-content {
            margin-top: 50px;
        }
    }
</style>
