<template>
 <main id = "Login">
    <div class="row">
      <div class="col-sm-4">
        <h2 align="center">Login</h2>
        <form @submit.prevent="loginUser">
          <div class="form-group" align="left">
            <label>Email</label>
            <input type="email" v-model="user.email" class="form-control" placeholder="Email" required>
          </div>
          <div class="form-group" align="left">
            <label>Password</label>
            <input type="password" v-model="user.password" class="form-control" placeholder="Password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </main>  
</template>

<script>
import axios from 'axios';

import { reactive } from 'vue';
import { useRouter } from 'vue-router';



export default {
  name: 'Login',
  components: {
    
  },
  data() {
    return {
      user: {
        email: '',
        password: '',
      },
    };
  },
  
  methods: {
    loginUser() {
      axios.post('/api/login', this.user)
        .then(({ data }) => {
          console.log(data);
          try {
            if (data.status === 'success') {
              alert('Login Successfully');

              axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.authorisation.token;

              localStorage.setItem('id', data.user.id);

              this.$router.push('/');
            } else {
              alert('Login failed');
            }
          } catch (err) {
            alert('Error, please try again');
          }
        })
        .catch(error => {
          console.error(error);
          alert('An error occurred, please try again');
        });
    },
  },

};
</script>
