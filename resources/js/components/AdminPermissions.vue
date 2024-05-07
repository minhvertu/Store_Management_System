<template>
    <div class="container-fluid" id="admin">
       <div class="error" v-if="error.message.length">
           <div class="alert alert-danger" role="alert">
               {{ error.message }}
           </div>
       </div>
       <div class="row">
            <div class="col">
                <div class="input-group rounded " style="width: 55%;">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" v-model="searchKeyword" @input="searchProducts" />
                    <span class="input-group-text bg-dark text-light" id="search-addon">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </span>
                </div>
            </div>
            <div class="col">
                <div class="text-end">
                    <button class="btn btn-outline-info me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                        data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"
                    >Add Permissions</button>

                    <button class="btn btn-outline-info me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                        data-bs-toggle="modal" data-bs-target="#createPermission" data-bs-whatever="@mdo"
                    >Create Permissions</button>
                </div>



                <form @submit.prevent="submitForm">
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Permissions Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="userPermission.user_id">
                                        <option disabled value="">Select Users</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name
                                            }}</option>
                                    </select>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="userPermission.permission_id">
                                        <option disabled value="">Select Permissions</option>
                                        <option v-for="permission in permissions" :key="permission.id" :value="permission.id">
                                            {{ permission.name }}</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Permissions</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form @submit.prevent="createPermission">
                    <div class="modal fade" id="createPermission" tabindex="-1" aria-labelledby="createPermissionLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Products Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Slug</label>
                                        <input class="form-control" type="text" id="name" v-model="permission.slug" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="sell_price" class="form-label">Name</label>
                                        <input class="form-control" type="text" id="sell_price"
                                            v-model="permission.name" />
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create Permission</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>

       <div>
           <table class="table table-bordered">
               <thead>
                   <tr>
                   <th scope="col">ID</th>
                   <th scope="col">User name</th>
                   <th scope="col">Permission</th>
                   </tr>
               </thead>
               <tbody>
                   <tr v-for="(userPermission, index) in userPermissions" :key="'userPermission-' + index">
                       <th scope="row">{{ userPermission.id }}</th>
                       <td>{{ userPermission.user.name }}</td>
                       <td>{{ userPermission.permission.name }}</td>
                   </tr>
               </tbody>
           </table>
       </div>
   </div>

</template>

<script>
   export default {
       name: "User",
       data () {
           return {
               userPermissions: [],
               userPermission: {
                    user_id: '',
                    permission_id: '',
               },
               permissions: [],
               permission: {
                    slug: '',
                    name: '',
               },
               users:[],
               error: {
                   message: ''
               },
           }
       },
       created () {
           this.getUserPermissions(),
           this.getPermissions(),
           this.getUsers()
       },
       methods: {
           getUserPermissions () {
               axios.get('api/userPermissions')
               .then(response => {
                   if (response.data.status === false) {
                       this.error.message = response.data.message
                   } else {
                       this.userPermissions = response.data
                   }
               })
               .catch(error => {
                   console.log(error)
               })
           },
           getUsers () {
                axios.get('api/users')
                .then(response => {
                    if (response.data.status === false) {
                        this.error.message = response.data.message
                    } else {
                        this.users = response.data
                    }
                })
                .catch(error => {
                    console.log(error)
                })
            },
            getPermissions () {
                axios.get('api/permissions')
                .then(response => {
                    if (response.data.status === false) {
                        this.error.message = response.data.message
                    } else {
                        this.permissions = response.data
                    }
                })
                .catch(error => {
                    console.log(error)
                })
            },
            async submitForm() {
                try {
                    await axios.post('/api/userPermissions', this.userPermission);
                    alert('Add Permissions Successfully');
                    window.location.href = '/adminPermissions';
                } catch (error) {
                    console.error(error);
                }
            },

            async createPermission() {
                try {
                    await axios.post('/api/permissions', this.permission);
                    alert('Create Permission Successfully');
                    window.location.href = '/adminPermissions';
                } catch (error) {
                    console.error(error);
                }
            },

       }
   }
</script>

<style>

</style>
