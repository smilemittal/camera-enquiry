<?php

namespace App\Exports;

use App\Models\Standard;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;


class StandardsExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array():array
    {
        $data= [];
        $standards = Standard::with('system_type')->get();
        $data[0] =['standards' => 'Standard',
                 'system_types' => 'System_types',
                ];
                $i=1;
        foreach($standards as $standard)
        {
                $data[$i]['standards'] = $standard->name; 
                $data[$i]['system_types'] = !empty($standard->system_type)?$standard->system_type->name: '';
            $i++;
           
        }
        
       //dd($data);
         return($data);
     }
}
    

