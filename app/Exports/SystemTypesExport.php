<?php

namespace App\Exports;

use App\Models\SystemType;
use Maatwebsite\Excel\Concerns\FromCollection;

class SystemTypesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SystemType::all();
    }
}
