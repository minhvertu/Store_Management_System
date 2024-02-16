<template>
    <main id ="Employee">
        <div class="error" v-if="error.message.length">
            <div class="alert alert-danger" role="alert">
                {{ error.message }}
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                  <router-link to="/employees/create" >Add Employee</router-link>
            </div>
             <!-- <div class="col-3">
                <button class="btn btn-primary" @click="saveEmployee">Save</button>
            </div>  -->
        </div>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col" class="center-text">ID</th>
                    <th scope="col" class="center-text">Tên</th>
                    <th scope="col" class="center-text">Mã nhân viên</th>
                    <th scope="col" class="center-text">Số điện thoại</th>
                    <th scope="col" class="center-text">Mã Lương</th>
                    <th scope="col" class="center-text">Số CCCD</th>
                    <th scope="col" class="center-text">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(employee, index) in employees" :key="'employee-' + index">
                        <th scope="row" class="center-text">{{ employee.id }}</th>
                        <td class="center-text">{{ employee.name }}</td>
                        <td class="center-text">{{ employee.employee_code }}</td>
                        <td class="center-text">{{ employee.phone_number }}</td>
                        <td class="center-text">{{ employee.salary_code }}</td>
                        <td class="center-text">{{ employee.card_id }}</td>
                        <td class="center-text">
                            <button @click="deleteEmployee(employee, index)" class="btn btn-sm btn-outline-danger">Delete</button>
                            <router-link :to="`/employees/${employee.id}/edit`" class="mx-2 p-2 col border btn btn-success">Edit</router-link> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</template>

<script>
    export default {
        name: "Task",
        data () {
            return {
                employees: [],
                salary_code: '',
                name: '',
                employee_code: '',
                phone_number: '',
                card_id: '',
                error: {
                    message: ''
                }
            }
        },
        created () {
            this.getEmployees()
        },
        methods: {
            getEmployees () {
                axios.get('api/employees')
                .then(response => {
                    this.employees = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            },
            deleteEmployee(employee, index) {
                axios.delete('api/employees/' + employee.id)
                .then(response => {
                    if (response.data.status === false) {
                        this.error.message = response.data.message
                        setTimeout(() => {
                            this.error.message = ''
                        }, 3000)
                    } else {
                        this.employees.splice(index, 1)
                    }
                })
                .catch(error => {
                    console.log(error)
                })
            }
        },

    }
</script>

<style lang="scss" scoped>
    .list-employees {
        margin-top: 50px;
    }
    .error {
        margin-bottom: 15px;
    }
    .center-text {
        text-align: center;
    }
    .table-bordered td {
    border: 1px solid #dee2e6;
    padding: 8px;
    text-align: center;
    }
    

</style>
