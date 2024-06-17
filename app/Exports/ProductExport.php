<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ProductExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public function headings(): array
    {
        return [
            'Name',
            'Product Code',
            'Import Price',
            'Sell Price',
            'Gender',
            'Brand',
            'Category',
            'Day Create',
            'Day Update'
        ];
    }

    public function collection()
    {
        return Product::all()->map(function ($product) {
            return [
                'name' => $product->name,
                'product_code' => $product->product_code,
                'import_price' => $product->import_price,
                'sell_price' => $product->sell_price,
                'gender' => $product->gender->name ?? '',
                'brand' => $product->brand->name ?? '', // Assuming brand is a relationship
                'category' => $product->category->name ?? '',
                'created_at' => $product->created_at ? $product->created_at->format('Y-m-d') : '',
                'updated_at' => $product->updated_at ? $product->updated_at->format('Y-m-d') : ''
            ];
        });
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
