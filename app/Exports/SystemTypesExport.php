<?php

namespace App\Exports;

use App\Models\SystemType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SystemTypesExport implements FromCollection ,WithHeadings , WithTitle
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

    public function title(): string
    {
        return 'System Types';
    }
    
}
