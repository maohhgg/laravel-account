<?php

namespace App\Exports;

use App\Collect;
use Maatwebsite\Excel\Concerns\FromCollection;

class CollectsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Collect::all();
    }
}
