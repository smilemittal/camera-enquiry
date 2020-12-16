<?php

namespace App\Imports;

use App\Models\SystemType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SystemTypesImport implements ToCollection,WithHeadingRow
{
    /**
    * @param array $rows
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection  $rows)
    {
        foreach ($rows as $row)
        {
            $system_type= SystemType::where('name','LIKE', $row['name'])->first();

            if(!$system_type)
            {
            $system_types = SystemType::create(['name' => $row['name']]);
            $system_type_id =$system_types->id;
            }
            else
            {
            $system_type_id =$system_type->id;
            }
        } 
    }
}
