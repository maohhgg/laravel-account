<?php

namespace App\Exports;

use App\RechargeOrder;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RechargeOrder::all();
    }
}
