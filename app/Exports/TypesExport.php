<?php

namespace App\Exports;

use App\Models\Type;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TypesExport implements FromCollection ,WithHeadings , WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Type::all();
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
        return 'Types';
    }

}
