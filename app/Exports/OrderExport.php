<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

class OrderExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return Collection
     */



    public function collection()
    {
        return Order::all()->map(function ($order) {
            return [
                'order_code' => $order->order_code ?? '',
                'price' => $order->price ?? '',
                'address' => $order->address ?? '',
                'detail' => $order->detail ?? '',
                'phone_number' => $order->phone_number ?? '',
                'user' => $order->user->name ?? '',
                'client' => $order->client->name ?? '',
                'status' => $order->status->name ?? '',
                'created_at' => $order->created_at ? $order->created_at->format('Y-m-d') : '',
                'updated_at' => $order->updated_at ? $order->updated_at->format('Y-m-d') : ''
            ];
        });
    }


    public function headings(): array
    {
        return [
            'Order Code',
            'Price',
            'Address',
            'Detail',
            'Phone Number',
            'Seller',
            'Client',
            'Status',
            'Date Create',
            'Date Receive'
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
