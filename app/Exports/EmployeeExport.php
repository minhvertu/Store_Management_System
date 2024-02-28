<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            'name',
            'employee_code',
            'phone_number',
            'card_id',
            'salary_code',
            'Created_at',
            'Updated_at'
        ];
    }
    public function collection()
    {
        return Employee::all();
    }
}
