<?php

namespace App\Exports;

use App\Models\Attribute;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttributeExport implements FromArray ,WithTitle
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
            'description'=>'Description',
            'system_type'=>'System_type',
            'type'=>'Type',
            'standard' => 'Standard'

         ];
        $attributes= Attribute::with('attribute_values','system_type','type')->get();
        foreach($attributes as $attribute){
            if(!empty($attribute->attribute_values) && count($attribute->attribute_values) > 0){
             foreach($attribute->attribute_values as $attribute_value)
             {

                 $data[] = [
                    'attribute' => $attribute->name,
                    'attribute_value' => $attribute_value->value,
                    'display_order'=> $attribute->display_order,
                    'description'=>$attribute->description,
                    'system_type'=>!empty($attribute->system_type)?$attribute->system_type->name: '',
                    'type'=>!empty($attribute->type) ?$attribute->type->name: '',
                    'standard'=>!empty($attribute_value->standard->name) ?$attribute_value->standard->name: '',

                   
                 ];
             }
            }else {
                $data[] = [
                    'attribute' => $attribute->name,
                    'attribute_value' =>'',
                    'display_order'=> $attribute->display_order,
                    'system_type'=>!empty($attribute->system_type)?$attribute->system_type->name: '',
                    'type'=>!empty($attribute->type) ?$attribute->type->name: '',
                    'description'=>$attribute->description,
                    'standard' => '',
                 ];

            }
        }
      //  dd($data);
        return($data);
    }

    public function title(): string
    {
        return 'Attributes and Attribute Values';
    }
}
