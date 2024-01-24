<template>
        <!-- <div class="user-login">
        </div> -->
        <div class ="container">
         <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
                      <li><a class="dropdown-item" href="/sidebar">SidebarTest</a></li>
              
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
          </nav>  -->
         
          
        </div> 
      
         
        <router-view/>
       
          <Sidebar/>
         
            
       
        
         

      
     

         
 

 
   


</template>


<script>
import { useRouter } from 'vue-router';
import Sidebar from './Sidebar.vue';


    export default {
      name: "App",
       components: {
      Sidebar,
     },
    
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
		padding: 2rem;

		@media (max-width: 1024px) {
			padding-left: 6rem;
		}
	}
}

</style> 
