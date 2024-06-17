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

                    <!-- <button class="btn btn-outline-info me-2" data-mdb-ripple-init data-mdb-ripple-color="dark"
                        data-bs-toggle="modal" data-bs-target="#createPermission" data-bs-whatever="@mdo"
                    >Create Permissions</button> -->
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

                <form @submit.prevent="updatePermission">
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel">Update Permission</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- Hiển thị dữ liệu sản phẩm hiện tại -->

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="editedUserPermission.user_id">
                                        <option disabled value="">Select Users</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name
                                            }}</option>
                                    </select>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="editedUserPermission.permission_id">
                                        <option disabled value="">Select Permission</option>
                                        <option v-for="permission in permissions" :key="permission.id" :value="permission.id">{{ permission.name }}</option>
                                    </select>

                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        v-model="editedUserPermission.new_permission_id">
                                        <option disabled value="">Select New Permission</option>
                                        <option v-for="permission in permissions" :key="permission.id" :value="permission.id">{{ permission.name }}</option>
                                    </select>

                                    <!-- Các trường thông tin khác -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Permission</button>
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
                   <th scope="col">User name</th>
                   <th scope="col">Permission</th>
                   <th scope="col">Action</th>

                   </tr>
               </thead>
               <tbody>
                   <tr v-for="(userPermission) in userPermissions" :key="userPermission">
                       <td class="center-text align-middle" >{{ userPermission.user.name }}</td>
                       <td class="center-text align-middle">{{ userPermission.permission.name }}</td>
                       <td class="center-text align-middle">
                            <span class="material-symbols-outlined me-2">
                                    <button @click="deleteUserPermission(userPermission)" type="button" class="btn btn-danger m-1 "
                                        data-mdb-ripple-init>delete_forever</button>
                             </span>
                                <span class="material-symbols-outlined me-2">
                                    <button type="button" class="btn btn-info m-1" data-mdb-ripple-init
                                        data-bs-toggle="modal" data-bs-target="#updateModal" data-bs-whatever="@mdo"
                                        @click="openUpdateModal(userPermission)">edit</button>
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
                            Add Permission Successfully
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
                            Update Permission Successfully
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
                            Delete Permission Successfully
                        </div>
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

               editedUserPermission: {

                permission_id: '',
                user_id: '',
                new_permission_id: '',

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

        async updatePermission() {
    try {
        const response = await axios.post('/api/userPermissionsUpdate', this.editedUserPermission);

        if (response.status === 200) {
            // Thực hiện các hành động cần thiết sau khi cập nhật thành công
            this.getUserPermissions(); // Cập nhật danh sách sản phẩm
            this.hideUpdateModal();
            this.showUpdateToast(); // Hiển thị toast message

            // Xóa dữ liệu đã cập nhật để chuẩn bị cho lần cập nhật tiếp theo
            this.editedUserPermission = {
                user_id: '',
                permission_id: '',
                new_permission_id: ''
            };
        } else {
            // Xử lý trường hợp lỗi từ server
            alert('Có lỗi xảy ra khi cập nhật quyền.');
        }
    } catch (error) {
        // Xử lý trường hợp lỗi từ client hoặc server
        console.error(error);
        alert('Có lỗi xảy ra khi cập nhật quyền.');
    }
},



        deleteUserPermission(userPermission) {
    axios.delete(`/api/userPermissions/${userPermission.user_id}/${userPermission.permission_id}`)
        .then(response => {
            if (response.data.status === true) {
                // Xóa thành công, cập nhật lại danh sách userPermissions

                        this.getUserPermissions(); // Cập nhật danh sách sản phẩm
                        this.showDeleteToast(); // Hiển thị toast message

            } else {
                alert('An error occurred while deleting user permission');
            }
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred while deleting user permission');
        });
},

        openUpdateModal(userPermission) {
            // Điền dữ liệu sản phẩm hiện tại vào biến editedProduct
            this.editedUserPermission = {
                user_id: userPermission.user_id,

                permission_id: userPermission.permission_id,

            };
            // Mở modal cập nhật sản phẩm
            $('#updateModal').modal('show');
        },
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
                    await axios.post('/api/userPermissions', this.userPermission)
                    .then((response) => {
                        this.getUserPermissions(); // Cập nhật danh sách sản phẩm
                        this.hideCreateModal();
                        this.showCreateToast(); // Hiển thị toast message
                    });
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
