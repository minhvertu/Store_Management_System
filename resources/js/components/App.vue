<template>
    <div class="container">
        <div class="user-login">
            <div class="username">
                <!-- User: {{ $root.user.name }} -->
            </div>
            <!-- <div class="logout">
                <a href="#" @click.prevent="logout">Logout</a>
            </div> -->
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">Navbar</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Link</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Dropdown Function Test
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="/task">Tasks</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item"  href="#" @click.prevent="logout">Logout</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="/users">Users</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
                <form class="d-flex">
                </form>
                <form class="d-flex">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
              </div>
            </div>
          </nav>
        
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
