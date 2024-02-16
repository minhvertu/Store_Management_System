<template>
    <div>
        <h2 v-if="isNewEmployee">Add Employee</h2>
        <h2 v-else>Edit Employee</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input class="form-control" type="text"  id="name" v-model="employee.name" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Employee Code</label>
                <input class="form-control" id="employee_code" v-model="employee.employee_code" />
            </div>
                <div class="mb-3">
                <label for="description" class="form-label">Phone Number</label>
                <input class="form-control" id="employee_code" v-model="employee.phone_number" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Salary Code</label>
                <input class="form-control" id="employee_code" v-model="employee.salary_code" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">CCCD</label>
                <input class="form-control" id="employee_code" v-model="employee.card_id" />
            </div>
            <div>
                <button type="submit" v-if="isNewEmployee" class="btn btn-primary">Add Employee</button>
                <button type="submit" v-else class="btn btn-primary">Update Employee</button>
                <button  @click="$router.push('/employeeManagement')" class="mx-2 p-2 col border btn btn-success">Back</button>
            </div>
        </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        employee: {
          id: '',
          name: '',
          card_id: '',
          phone_number: '',
          employee_code: '',
          salary_code: '',
        }
      };
    },
    computed: {
      isNewEmployee() {
        return !this.$route.path.includes('edit');
      }
    },
    async created() {
      if (!this.isNewEmployee) {
        const response = await axios.get(`/api/employees/${this.$route.params.id}`);
        this.employee = response.data;
      }
    },
    saveEmployee () {
        axios.post('api/employees', {
            salary_code: this.salary_code,
            name: this.name,
            card_id: this.card_id,
            phone_number: this.phone_number,
            employee_code: this.employee_code,
        })
        .then(response => {
            if (response.data.status === false) {
                this.error.message = response.data.message
                setTimeout(() => {
                    this.error.message = ''
                }, 3000)
            } else {
                this.employees.push(response.data)
            }
        })
        .catch(error => {
            console.log(error)
        })
    },
    methods: {
      async submitForm() {
        try {
            if (this.isNewEmployee) {
            await axios.post('/api/employees', this.employee);
            alert('Add Employee Successfully');
            this.$router.push('/employeeManagement');
          } else {
            await axios.put(`/api/employees/${this.$route.params.id}`, this.employee);
            alert('Update Successfully');
          }
        } catch (error) {
          console.error(error);
        }
      }
    },

    async mounted() {
    try {
    const response = await axios.get(`/api/employees/${this.$route.params.id}`);
    this.employee = response.data;
    console.log(response.data)
    } catch (error) {
    console.error(error);
    }
}
  }
  </script>