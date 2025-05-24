<?php

namespace Modules\Order\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Modules\Order\Repositories\Dashboard\OrderRepository as Order;
use Modules\Order\Transformers\Dashboard\OrderCoursesResource;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersCoursesReportsExport implements FromCollection, WithHeadings,ShouldAutoSize,WithStyles
{

    protected $orders;

    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    public function headings():array{
        return [
          '#', 'المستخدم', 'رقم الهاتف', 'المادة', 'تاريخ الانشاء', 'تاريح الانتهاء', 'المجموع الكلي', 'المجموع النهائي'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 13]],
        ];
    }


    public function collection()
    {
        $query = $this->orders->QueryTable(request())->where('order_status_id',1)->whereHas('orderCourses')->with('orderCourses');
        return OrderCoursesResource::collection($query->get());
    }
}
