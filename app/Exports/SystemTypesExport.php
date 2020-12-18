<?php

namespace App\Exports;

use App\Models\SystemType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SystemTypesExport implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SystemType::all();
    }

    public function headings(): array
    {
    	return [
    		"id",
    		"name",
    		"created_at", 
    		"updated_at"];
    }
}
