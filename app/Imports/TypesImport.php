<?php

namespace App\Imports;

use App\Models\Type;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TypesImport implements  ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection  $rows)
    {
        foreach ($rows as $row)
        {
            //get systemtype, if exists, get id, otherwise create new systemtype and get its id
            $type= Type::where('name','LIKE', $row['name'])->first();

            if(!$type)
            {  
            $type = Type::create(['name' => $row['name']]);
            $type_id =$type->id;
            }
            else
            {
            $type_id =$type->id;
            }
        } 
    }
}
