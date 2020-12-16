<?php

namespace App\Exports;

use App\Models\Standard;
use Maatwebsite\Excel\Concerns\FromCollection;

class StandardsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Standard::all();
    }
}
