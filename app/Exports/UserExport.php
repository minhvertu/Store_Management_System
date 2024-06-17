<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

class UserExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'address' => $user->address,
                'role' => $user->role->name ?? '',
                'shop' => $user->shop->name ?? '',
                'phone_number' => $user->phone_number,
                'employee_code' => $user->employee_code,
                'date_of_birth' => $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Address',
            'Role',
            'Shop',
            'Phone Number',
            'Employee Code',
            'Date of Birth',
        ];
    }

    public function registerEvents(): array
    {
        $color = 'CCEEFF'; // Light blue color
        return [
            AfterSheet::class => function(AfterSheet $event) use ($color) {
                // Get the range of the data table
                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();
                $range = 'A1:' . $highestColumn . $highestRow;

                // Set the border for the table
                $event->sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Set the color for each row
                for ($row = 2; $row <= $highestRow; $row++) {
                    $event->sheet->getStyle('A' . $row . ':' . $highestColumn . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['rgb' => $color],
                        ],
                    ]);
                    // Alternate color for rows
                    $color = ($color == 'CCEEFF') ? 'FFFFCC' : 'CCEEFF';
                }

                // Align the content to the left
                $event->sheet->getStyle('A1:' . $highestColumn . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            },
        ];
    }
}
