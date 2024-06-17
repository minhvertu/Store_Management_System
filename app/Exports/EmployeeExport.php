<?php

namespace App\Exports;

use App\Models\Employeez;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;



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
        $color = 'CCEEFF'; // Màu xanh nhạt
        return [
            AfterSheet::class => function(AfterSheet $event) use ($color) {
                // Lấy range của bảng dữ liệu
                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();
                $range = 'A1:' . $highestColumn . $highestRow;

                // Thiết lập border cho bảng
                $event->sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Thiết lập màu cho từng dòng
                for ($row = 2; $row <= $highestRow; $row++) {
                    $event->sheet->getStyle('A' . $row . ':' . $highestColumn . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['rgb' => $color],
                        ],
                    ]);
                    // Đảo màu để xen kẽ
                    $color = ($color == 'CCEEFF') ? 'FFFFCC' : 'CCEEFF';
                }

                // Canh trái nội dung trong bảng
                $event->sheet->getStyle('A1:' . $highestColumn . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            },
        ];
    }
}
