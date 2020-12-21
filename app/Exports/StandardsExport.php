<?php

namespace App\Exports;

use App\Models\Standard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;


class StandardsExport implements FromCollection, WithHeadings,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Standard::all();
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
        return 'Standards';
    }
    
}
