<template>
    <div class ="container-fluid" id="Employee">
        <div class="error" v-if="error.message.length">
            <div class="alert alert-danger" role="alert">
                {{ error.message }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <!-- <div class="input-group rounded">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" v-model="searchKeyword" @input="searchEmployees" />
                    <span class="input-group-text border" id="search-addon">
                        <span class="material-symbols-outlined">search</span>
                    </span>
                </div>  -->
            </div>
            <div class="col">
                <div class="text-end">
                    <router-link to="/employees/create" v-if="addPermission" class="p-2 col border btn btn-success">Add
                        Employee</router-link>
                    <button class="p-2 col border btn btn-success" style="height: 39px;" @click="toggleListView">
                        <span class="material-symbols-outlined">{{ listView ? 'format_list_bulleted' : 'grid_on' }}</span>
                    </button>
                    <button class="p-2 col border btn btn-success" @click="exportEmployees" >
                        Export Data
                    </button>
                </div>
            </div>
        </div>

        <div class = "table-responsive">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="center-text table-primary">ID</th>
                        <th scope="col" class="center-text table-primary">Name</th>
                        <th scope="col" class="center-text table-primary">Employee Code</th>
                        <th scope="col" class="center-text table-primary">Phone Number</th>
                        <th scope="col" class="center-text table-primary">Salary Code</th>
                        <th scope="col" class="center-text table-primary">CCCD</th>
                        <th scope="col" class="center-text table-primary">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(employee, index) in filteredEmployees" :key="employee.id">
                        <td class="center-text table-info">{{ employee.id }}</td>
                        <td class="center-text table-info">{{ employee.name }}</td>
                        <td class="center-text table-info">{{ employee.employee_code }}</td>
                        <td class="center-text table-info">{{ employee.phone_number }}</td>
                        <td class="center-text table-info">{{ employee.salary_code }}</td>
                        <td class="center-text table-info">{{ employee.card_id }}</td>
                        <td class="center-text table-info">
                            <span class="material-symbols-outlined">
                                <button @click="deleteEmployee(employee, index)"
                                    class="mx-2 p-2 col border btn btn-sm btn-outline-danger">delete_forever
                                </button>
                            </span>
                            <span class="material-symbols-outlined">
                                <router-link :to="`/employees/${employee.id}/edit`"
                                    class="mx-2 p-2 col border btn btn-success">edit
                                </router-link>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="showPagination">
                <ul class="pagination justify-content-center">
                    <li :class="{ 'disabled': currentPage === 1 }">
                        <a class="page-link" href="#" @click.prevent="prevPage">Previous</a>
                    </li>
                    <li v-for="page in totalPages" :key="page" :class="{ 'active': currentPage === page }">
                        <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
                    </li>
                    <li :class="{ 'disabled': currentPage === totalPages }">
                        <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Employee",
    data() {
        return {
            user_permissions: {},
            employees: [],
            searchKeyword: '',
            addPermission: true,
            listView: true,
            currentPage: 1, // Trang hiện tại
            pageSize: 5, // Số lượng nhân viên trên mỗi trang
            error: {
                message: ''
            }
        }
    },
    created() {
        this.getEmployees();
        this.blockAddPermission();
    },
    methods: {
        getEmployees() {
            axios.get('api/employees')
                .then(response => {
                    this.employees = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        deleteEmployee(employee, index) {
            axios.delete('api/employees/' + employee.id)
                .then(response => {
                    if (response.data.status === false) {
                        this.error.message = response.data.message;
                        setTimeout(() => {
                            this.error.message = '';
                        }, 3000);
                    } else {
                        this.employees.splice(index, 1);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        goToPage(page) {
            this.currentPage = page;
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        searchEmployees() {
            const keyword = this.searchKeyword.toLowerCase();
            this.filteredEmployees = this.employees.filter(employee => {
                return (
                    employee.name.toLowerCase().includes(keyword) ||
                    employee.employee_code.toLowerCase().includes(keyword) ||
                    employee.phone_number.includes(keyword) ||
                    employee.salary_code.toLowerCase().includes(keyword) ||
                    employee.card_id.toLowerCase().includes(keyword)
                );
            });
        },
        toggleListView() {
            this.listView = !this.listView;
        },
        blockAddPermission() {
            let user_permissions = JSON.parse(localStorage.getItem('permission_id'));

            for (let i = 0; i < user_permissions.length; i++) {

                if (user_permissions[i].id == 5) {
                    this.addPermission = true;
                    return this.addPermission;
                }
            }
            return this.addPermission = false;
        },

        exportEmployees() {
            axios.get('/api/employees_export', { responseType: 'arraybuffer' })
                .then(response => {
                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');
                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'employees.xlsx');
                    document.body.appendChild(fileLink);
                    fileLink.click();
                    alert('Data exported successfully!');
                })
                .catch(error => {
                    console.error('Export failed:', error);
                    alert('Failed to export data. Please try again later.');
                });
        }
    },
    computed: {
        filteredEmployees() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            const endIndex = startIndex + this.pageSize;
            const keyword = this.searchKeyword.toLowerCase();
            const filteredEmployees = this.employees.filter(employee => {
                return (
                    employee.name.toLowerCase().includes(keyword) ||
                    employee.employee_code.toLowerCase().includes(keyword) ||
                    employee.phone_number.includes(keyword) ||
                    employee.salary_code.toLowerCase().includes(keyword) ||
                    employee.card_id.toLowerCase().includes(keyword)
                );
            });
            return filteredEmployees.slice(startIndex, endIndex);
        },
        totalPages() {
            return Math.ceil(this.employees.length / this.pageSize);
        },
        showPagination() {
            if (this.filteredEmployees.length >= 4 || this.nextPage > 1) {
                return true;

            } else if (this.filteredEmployees.length < 5 && this.nextPage == 1) {
                return false;
            }
            return true;
        },

    }
}
</script>

<style lang="scss" scoped>
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
