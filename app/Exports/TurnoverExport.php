<?php

namespace App\Exports;

use App\Turnover;
use Maatwebsite\Excel\Concerns\FromCollection;

class TurnoverExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Turnover::all();
    }
}
