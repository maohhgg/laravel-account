<?php
namespace App\Exports;

use App\Models\Turnover;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TurnoverExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function headings(): array
    {
        return [
            '用户',
            '交易类型',
            '交易金额',
            '第三方手续费',
            '费率 %',
            '总手续费',
            '交易后余额',
            '交易时间',
        ];
    }

    public function map($turnover): array
    {
        return [
            $turnover->user->name,
            $turnover->type->name,
            $turnover->data,
            $turnover->third_tax,
            $turnover->tax_rate,
            $turnover->tax,
            $turnover->history,
            $turnover->created_at
        ];

    }

    public function query()
    {
        return Turnover::select(["user_id","type_id","data","third_tax","tax_rate","tax",'history',"created_at"]);
    }
}
