<template>
    <div class="container-fluid" id="Employee">
      <div class="error" v-if="error.message.length">
        <div class="alert alert-danger" role="alert">
          {{ error.message }}
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="input-group rounded" style="width: 55%;">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
              aria-describedby="search-addon" v-model="searchKeyword" @input="searchEmployees" />
              <span class="input-group-text bg-dark text-light" id="search-addon">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
              </span>
          </div>
        </div>
        <div class="col">
          <div class="text-end">
            <router-link to="/employees/create" v-if="addPermission" class="btn btn-outline-info" data-mdb-ripple-init data-mdb-ripple-color="dark">Add
              Employee</router-link>
            <button class="btn btn-outline-success" data-mdb-ripple-init data-mdb-ripple-color="dark" @click="exportEmployees">
              Export Data
            </button>
          </div>
        </div>
      </div>
  
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col" class="center-text">
                
              </th>
              <th scope="col" class="center-text" @click="sortBy('id')">
                ID
                <span class="arrow" :class="sortOrders['id'] > 0 ? 'asc' : 'dsc'"></span>
              </th>
              <th scope="col" class="center-text" @click="sortBy('name')">
                Name
                <span class="arrow" :class="sortOrders['name'] > 0 ? 'asc' : 'dsc'"></span>
              </th>
              <th scope="col" class="center-text" @click="sortBy('employee_code')">
                Employee Code
                <span class="arrow" :class="sortOrders['employee_code'] > 0 ? 'asc' : 'dsc'"></span>
              </th>
              <th scope="col" class="center-text" @click="sortBy('phone_number')">
                Phone Number
                <span class="arrow" :class="sortOrders['phone_number'] > 0 ? 'asc' : 'dsc'"></span>
              </th>
              <th scope="col" class="center-text" @click="sortBy('salary_code')">
                Salary Code
                <span class="arrow" :class="sortOrders['salary_code'] > 0 ? 'asc' : 'dsc'"></span>
              </th>
              <th scope="col" class="center-text" @click="sortBy('card_id')">
                CCCD
                <span class="arrow" :class="sortOrders['card_id'] > 0 ? 'asc' : 'dsc'"></span>
              </th>
              <th scope="col" class="center-text">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(employee, index) in filteredEmployees" :key="employee.id">
              <td> <input type="checkbox" v-model="selectedEmployees[index]"></td>
              <td class="center-text">{{ employee.id }}  </td>
              <td class="center-text">{{ employee.name }}</td>
              <td class="center-text">{{ employee.employee_code }}</td>
              <td class="center-text">{{ employee.phone_number }}</td>
              <td class="center-text">{{ employee.salary_code }}</td>
              <td class="center-text">{{ employee.card_id }}</td>
              <td class="center-text">
                <span class="material-symbols-outlined">
                  <button @click="deleteEmployee(employee, index)"
                    class="mx-2 p-2 col border btn btn-sm btn-outline-danger">delete_forever
                  </button>
                </span>
                <span class="material-symbols-outlined">
                  <router-link :to="`/employees/${employee.id}/edit`"
                    class="mx-2 p-2 col border btn ">edit
                  </router-link>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="showPagination">
          <ul class="pagination justify-content-end" style="font-size: 80%">
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
        pageSize: 10, // Số lượng nhân viên trên mỗi trang
        error: {
          message: ''
        },
        sortKey: "", // Cột hiện tại được sắp xếp
        sortOrders: {}, // Hướng sắp xếp của các cột
        selectedEmployees: [],
      }
    },
  
    mounted() {
      this.getEmployees();
    },
    created() {
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
      },
  
      // Phương thức sắp xếp
      sortBy(key) {
        // Kiểm tra xem cột hiện tại có phải là cột đang được sắp xếp không
        if (this.sortKey === key) {
          // Đảo hướng sắp xếp
          this.sortOrders[key] = this.sortOrders[key] * -1;
        } else {
          // Nếu không phải, đặt cột hiện tại và hướng sắp xếp mới
          this.sortKey = key;
          this.sortOrders[key] = 1;
        }
  
        // Sắp xếp dữ liệu
        this.filteredEmployees.sort((a, b) => {
          let modifier = this.sortOrders[key];
          if (a[key] < b[key]) return -1 * modifier;
          if (a[key] > b[key]) return 1 * modifier;
          return 0;
        });
      },
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

  
  <style scoped>
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
  
  
  .pagination li a,
  .pagination li span {
    border-radius: 20px;
    padding: 8px 16px;
  }
  
  /* CSS cho hình mũi tên chỉ ra hướng sắp xếp */
  .arrow {
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 0.25em;
    vertical-align: middle;
    border-top: 0.3em solid;
    border-right: 0.3em solid transparent;
    border-bottom: none;
    border-left: 0.3em solid transparent;
  }
  .asc {
    border-top: none;
    border-bottom: 0.3em solid;
  }
  .dsc {
    border-top: 0.3em solid;
    border-bottom: none;
  }
  </style>
  