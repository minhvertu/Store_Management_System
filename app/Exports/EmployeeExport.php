<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;



class EmployeeExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{ 
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Employee_code',
            'Phone_number',
            'Card_id',
            'Salary_code',
            'Created_at',
            'Updated_at'
        ];
    }
    public function collection()
    {
        return Employee::all();
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
