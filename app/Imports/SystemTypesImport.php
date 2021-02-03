<?php

namespace App\Imports;

use App\Models\SystemType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SystemTypesImport implements ToCollection,WithHeadingRow
{
    public $total_system_types = 0;
    public $existing_system_types = 0;
    public $imported_system_types = 0;
    /**
    * @param array $rows
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection  $rows)
    {
        $system_types_existing = 0;
        $system_types_imported = 0;
        foreach ($rows as $row)
        {
            //get systemtype, if exists, get id, otherwise create new systemtype and get its id
            $system_type= SystemType::where('name','LIKE', $row['name'])->first();

            if(!$system_type)
            {  
            $system_types = SystemType::create(['name' => $row['name']]);
            $system_type_id =$system_types->id;
            $system_types_imported++;
            }
            else
            {
            $system_type_id =$system_type->id;
            $system_types_existing++;
            }
        } 
        $this->existing_system_types = $system_types_existing;
        $this->imported_system_types = $system_types_imported;
    }
}
