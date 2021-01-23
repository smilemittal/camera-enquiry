<?php

namespace App\Imports;

use App\Models\Standard;
use App\Models\SystemType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

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
            //get SystemType, if exists, get id, otherwise create new SystemType and get its id
            //dd($rows);
           $system_type = SystemType::where('name', 'LIKE', $row['system_type'])->first();
           if($system_type){
               $system_type_id = $system_type->id;
           }else{
               $system_types = SystemType::create([
                   'name' => $row['system_type'],
               ]);
               $system_type_id = $system_types->id;
           }
           //get standard, if exists, get id, otherwise create new standard and get its id
           $standard= Standard::where('name','LIKE', $row['standard'])->where('system_type_id', 'LIKE', $system_type_id)->first();

            if(!$standard){
            $standards = Standard::create([
                            'name' => $row['standard'],
                            'system_type_id'=> $system_type_id,
                        ]);
            
            }
            

           
        } 
    }
}
