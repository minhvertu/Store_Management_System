
<template>
    <div class="container-fluid">
        <div class="col">
        <div class="text-end">
          <button class="btn btn-outline-success" data-mdb-ripple-init data-mdb-ripple-color="dark"
            @click="exportEmployees">
            Export Data
          </button>
        </div>
      </div>
    <DataTable :data="employees" :columns="columns" class="table table-bordered table-striped data-table1 display">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Employee Code</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Role</th>
                <th>Shop</th>
            </tr>
        </thead>
    </DataTable>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
                    <div
                        id="exportToast"
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
                            Export Data Successfully
                        </div>
                    </div>
                </div>
</template>

<script>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';

import DataTableLib from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';
// import pdfmake from 'pdfmake';

DataTable.use(DataTableLib);
// DataTable.use(pdfmake);
DataTable.use(DataTablesCore);
export default {

    components: { DataTable },
    data() {
        return {
            employees: null,
            columns: [
                {
                    data: null,
                    render: function (data, type, row) {
                        return `<div class="image-container" style="width: 80px; height: 80px; overflow: hidden;">
                            <img src="/storage/${row.image}" alt="Profile Image" class="shadow-sm border-radius-lg border border-1" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>`;
                    }
                },
                {data:'name'},
                {data:'birth_day'},
                {data:'employee_code'},
                {data: 'email'},
                {data: 'phone_number'},
                {data: 'role.name'},
                {data: 'shop.name'},

            ],

        }
    },
    methods: {
        showExportToast() {
            var myToast = new bootstrap.Toast(
                document.getElementById("exportToast")
            ); // Tạo một thể hiện của toast
            myToast.show(); // Hiển thị toast
        },

        exportEmployees() {
      axios.get('/api/users_export', { responseType: 'arraybuffer' })
        .then(response => {
          var fileURL = window.URL.createObjectURL(new Blob([response.data]));
          var fileLink = document.createElement('a');
          fileLink.href = fileURL;
          fileLink.setAttribute('download', 'users.xlsx');
          document.body.appendChild(fileLink);
          fileLink.click();
            this.showExportToast();
        })
        .catch(error => {
          console.error('Export failed:', error);
          alert('Failed to export data. Please try again later.');
        });
    },

        getEmployees() {
            axios.get('api/users')
                .then(response => {
                    this.employees = response.data;
                    console.log(this.employees);

                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
    created () {
        this.getEmployees();
    },
}
</script>
