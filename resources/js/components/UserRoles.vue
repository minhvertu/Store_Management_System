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
                    >Add Roles</button>

                    <!-- <button class="btn btn-outline-info me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                        data-bs-toggle="modal" data-bs-target="#createRole" data-bs-whatever="@mdo"
                    >Create Roles</button> -->
                </div>



                <form @submit.prevent="submitForm">
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Roles Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="userRole.user_id">
                                        <option disabled value="">Select Users</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name
                                            }}</option>
                                    </select>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="userRole.role_id">
                                        <option disabled value="">Select Roles</option>
                                        <option v-for="role in roles" :key="role.id" :value="role.id">
                                            {{ role.name }}</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Roles</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <form @submit.prevent="updateUser">
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel">Update Role</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- Hiển thị dữ liệu sản phẩm hiện tại -->

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="editedUser.role_id">
                                        <option disabled value="">Select Role</option>
                                        <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name
                                            }}</option>
                                    </select>

                                    <!-- Các trường thông tin khác -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Role</button>
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
                   <th scope="col">Name</th>
                   <th scope="col">Email</th>
                   <th scope="col">Role</th>
                   </tr>
               </thead>
               <tbody>
                   <tr v-for="(user) in users" :key="user.id">
                       <td class="center-text align-middle">{{ user.name }}</td>
                       <td class="center-text align-middle">{{ user.email }}</td>
                       <td class="center-text align-middle">{{ user.role.name }}</td>

                       <td class="center-text align-middle">
                            <span class="material-symbols-outlined me-2">
                                    <button @click="deleteUserPermission(userPermission)" type="button" class="btn btn-danger m-1 "
                                        data-mdb-ripple-init>delete_forever</button>
                             </span>
                                <span class="material-symbols-outlined me-2">
                                    <button type="button" class="btn btn-info m-1" data-mdb-ripple-init
                                        data-bs-toggle="modal" data-bs-target="#updateModal" data-bs-whatever="@mdo"
                                        @click="openUpdateModal(user)">edit</button>
                                </span>
                       </td>
                   </tr>
               </tbody>
           </table>
       </div>
   </div>



   <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                    <div
                        id="createToast"
                        class="toast"
                        role="alert"
                        aria-live="assertive"
                        aria-atomic="true"
                    >
                        <div class="toast-header">
                            <strong class="me-auto">Vertu Phan Boutique</strong>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="toast"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="toast-body">
                            Add Roles Successfully
                        </div>
                    </div>
                </div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                    <div
                        id="updateToast"
                        class="toast"
                        role="alert"
                        aria-live="assertive"
                        aria-atomic="true"
                    >
                        <div class="toast-header">
                            <strong class="me-auto">Vertu Phan Boutique</strong>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="toast"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="toast-body">
                            Update Roles Successfully
                        </div>
                    </div>
                </div>

                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                    <div
                        id="updateToast"
                        class="toast"
                        role="alert"
                        aria-live="assertive"
                        aria-atomic="true"
                    >
                        <div class="toast-header">
                            <strong class="me-auto">Vertu Phan Boutique</strong>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="toast"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="toast-body">
                            Error
                        </div>
                    </div>
                </div>

                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                    <div
                        id="deleteToast"
                        class="toast"
                        role="alert"
                        aria-live="assertive"
                        aria-atomic="true"
                    >
                        <div class="toast-header">
                            <strong class="me-auto">Vertu Phan Boutique</strong>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="toast"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="toast-body">
                            Delete Roles Successfully
                        </div>
                    </div>
                </div>


</template>

<script>
   export default {
       name: "User",
       data () {
           return {
               userRoles: [],
               userRole: {
                    user_id: '',
                    role_id: '',
               },

               editedUser : {
                id: '',
                name: '',
                role_id: '',
               },
               editedUserRole: {

                role_id: '',
                user_id: '',

               },
               roles: [],
               role: {
                id: '',
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
           this.getUserRoles(),
           this.getRoles(),
           this.getUsers()
       },
       methods: {

        hideCreateModal() {
            const modalEl = document.getElementById("exampleModal");
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        },

        hideUpdateModal() {
            const modalEl = document.getElementById("updateModal");
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        },

        showDeleteToast() {
            var myToast = new bootstrap.Toast(
                document.getElementById("deleteToast")
            ); // Tạo một thể hiện của toast
            myToast.show(); // Hiển thị toast
        },

        showUpdateToast() {
            var myToast = new bootstrap.Toast(
                document.getElementById("updateToast")
            ); // Tạo một thể hiện của toast
            myToast.show(); // Hiển thị toast
        },

        showCreateToast() {
            var myToast = new bootstrap.Toast(
                document.getElementById("createToast")
            ); // Tạo một thể hiện của toast
            myToast.show(); // Hiển thị toast
        },

        showErrorToast() {
            var myToast = new bootstrap.Toast(
                document.getElementById("errorToast")
            ); // Tạo một thể hiện của toast
            myToast.show(); // Hiển thị toast
        },


//         async updateUserRole() {
//     try {
//         const response = await axios.post('/api/userRolesUpdate', this.editedUserRole);

//         if (response.data.status) {
//             alert('User Role updated successfully');

//             this.editedUserRole = {
//                 user_id: '',
//                 role_id: ''
//             };
//             window.location.href = '/userRoles';


//         } else {
//             alert(response.data.message);
//         }
//     } catch (error) {
//         console.error(error);
//         alert('An error occurred while updating user role.');
//     }
// },


    async updateUser() {
            try {
                await axios.put(`/api/editProfile/${this.editedUser.id}`, this.editedUser)
                .then((response) => {
                        this.getUsers(); // Cập nhật danh sách sản phẩm
                        this.hideUpdateModal();
                        this.showUpdateToast(); // Hiển thị toast message
                    });
            } catch (error) {
                console.error(error);
            }
        },



        openUpdateModal(user) {
            // Điền dữ liệu sản phẩm hiện tại vào biến editedProduct
            this.editedUser = {

                id : user.id,
                name : user.name,

                role_id: user.role_id,

            };
            // Mở modal cập nhật sản phẩm
            $('#updateModal').modal('show');
        },

           getUserRoles () {
               axios.get('api/userRoles')
               .then(response => {
                   if (response.data.status === false) {
                       this.error.message = response.data.message
                   } else {
                       this.userRoles = response.data
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
            getRoles () {
                axios.get('api/roles')
                .then(response => {
                    if (response.data.status === false) {
                        this.error.message = response.data.message
                    } else {
                        this.roles = response.data
                    }
                })
                .catch(error => {
                    console.log(error)
                })
            },
            async submitForm() {
                try {
                    await axios.post('/api/userRoles', this.userRole);
                    alert('Add Roles Successfully');
                    window.location.href = '/userRoles';
                } catch (error) {
                    console.error(error);
                }
            },

            async createRole() {
                try {
                    await axios.post('/api/roles', this.role);
                    alert('Create Role Successfully');
                    window.location.href = '/userRoles';
                } catch (error) {
                    console.error(error);
                }
            },

       }
   }
</script>

<style>

</style>
