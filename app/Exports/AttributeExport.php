<?php

namespace App\Exports;

use App\Models\Attribute;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class AttributeExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $data = [];
        $data[] = [
            'attribute' =>'Attribute',
            'attribute_value' => 'Attribute_value',
            'display_order'=> 'Display_order',
            'system_type_id'=>'System_type_id',
            'type'=>'Type',
         ];
        $attributes= Attribute::with('attribute_values')->get();
        foreach($attributes as $attribute){
            if(!empty($attribute->attribute_values) && count($attribute->attribute_values) > 0){
             foreach($attribute->attribute_values as $attribute_value)
             {
                 
                 $data[] = [
                    'attribute' => $attribute->name,
                    'attribute_value' => $attribute_value->value,
                    'display_order'=> $attribute->display_order,
                    'system_type_id'=>$attribute->system_type_id,
                    'type'=>$attribute->type,
                 ];
             } 
            }
        }
        return($data);
    }
}