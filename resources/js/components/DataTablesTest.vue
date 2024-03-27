<!-- <script setup>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
 
DataTable.use(DataTablesCore);
 
const 
</script> -->

<template>
    <DataTable :data="employees" :columns="columns" class="table table-bordered table-striped data-table1 display">
        <thead>
            <tr>
                <th>Aanme</th>
                <th>phone_number</th>
                <th>phonasdadmber</th>
                <th>phonasdader</th>
                <th>phoasdasmber</th>
            </tr>
        </thead>
    </DataTable>
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
                {data:'name'},
                {data:'phone_number'},
                {data: 'salary_code'},
                {data: 'employee_code'},
                {data: 'card_id'},
            ],
            data: [
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
                [1, 2],
                [3, 4],
            ],
        }
    },
    methods: {
        getEmployees() {
            axios.get('api/employees')
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