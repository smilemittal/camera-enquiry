<?php

namespace App\Imports;

use App\Models\Type;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TypesImport implements  ToCollection, WithHeadingRow
{
    public $total_types = 0;
    public $existing_types = 0;
    public $imported_types = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection  $rows)
    {
        $types_existing = 0;
        $types_imported = 0;

        $this->total_types = count($rows);
        foreach ($rows as $row)
        {
            //get systemtype, if exists, get id, otherwise create new systemtype and get its id
            $type= Type::where('name','LIKE', $row['name'])->first();

            if(!$type)
            {  
                $type = Type::create(['name' => $row['name']]);
                $type_id =$type->id;
                $types_imported++;
            }
            else
            {
                $type_id =$type->id;
                $types_existing++;
            }
        }
        $this->existing_types = $types_existing;
        $this->imported_types = $types_imported;
    }
}
