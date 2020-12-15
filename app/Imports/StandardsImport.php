<?php

namespace App\Imports;

use App\Models\Standard;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StandardsImport implements ToCollection,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
           $standard= Standard::where('name','LIKE', $row['name'])->first();

            if(!$standard)
            {
            $standards = Standard::create(['name' => $row['name']]);
            $standards_id =$standards->id;
            }
            else
            {
            $standard_id =$standard->id;
            }
        } 
    }
}
