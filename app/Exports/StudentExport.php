<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithDefaultStyles, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users = User::getStudents(true);

        return $users;
    }
    public function defaultStyles(Style $defaultStyle)
    {
        // Thiết lập các style mặc định cho tất cả các ô
        $defaultStyle->applyFromArray([
            'font' => [
                'name' => 'Times New Roman',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        // Thêm các tùy chọn style khác tại đây nếu cần

        // Trả về $defaultStyle sau khi đã cấu hình
        return $defaultStyle;
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        $sheet->getRowDimension(1)->setRowHeight(24);
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        return [
            // Style the first row as bold text.
            'A1' => [
                'font' => ['bold' => true, 'size' => 18],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'EEEEEE'],
                ],
            ],

            // Styling a specific cell by coordinate.
            2 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '7FFF7F'],
                ],

            ],


        ];
    }
    public function headings(): array
    {
        return [['Danh sách học sinh'], [
            'Mã học sinh',
            'Tên học sinh',
            'Email',
            'Lớp',
            'Giới tính',
            'Phụ huynh',
            'Ngày sinh',

        ]];
    }
    public function map($user): array
    {

        $gender = 'Khác';
        if ($user->gender == 1)
            $gender = 'Nam';
        elseif ($user->gender == 2)
            $gender = 'Nữ';

        elseif ($user->gender == 3)
            $gender = 'Khác';
        return [
            $user->admission_number,
            $user->name . ' ' . $user->last_name,
            $user->email,
            $user->class_name,
            $gender,
            $user->parent_name . ' ' . $user->parent_last_name,
            !empty($user->date_of_birth) ? date('d-m-Y', strtotime($user->date_of_birth)) : ''


        ];
    }
}
