<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\Standard;
use App\Models\SystemType;
use App\Models\Type;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromArray;

class ProductAttributesExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array():array
    {
        $data= [];
        $attributes = Attribute::get();
        $data[0] =['product'    => 'Product name',
                 'standards'    => 'Standard',
                 'system_types' => 'System type',
                 'types'        => 'Type',
                 'priority'     => 'Priority',
                ];
        foreach($attributes as $attribute)
        {
            if(!in_array($attribute->name,$data[0]))
            {
                $data[0][$attribute->name] = $attribute->name; 
            }
        }
         $products= Product::with('product_attributes.attribute_value.attribute','product_attributes.attribute', 'standards','system_types','types')->get();
         $i=1;
         foreach($products as $product)
         {  
            $data[$i] =[
                'product' => $product->name,
                'standards'=>!empty($product->standards)?$product->standards->name: '',
                'system_types'=>!empty($product->system_types)?$product->system_types->name: '',
                'types'=>!empty($product->types)?$product->types->name: '',
                'priority'=>$product->priority,
            ];
            foreach($attributes as $attribute)
            
                {
                    if(!in_array_r($attribute->name,$data[$i]))
                    {
                    $data[$i][$attribute->name] ='';
                    }
                }
            foreach($product->product_attributes as $product_attributes)
            {  
            if(!empty($product_attributes->attribute_value->attribute)){ 
             $data[$i][$product_attributes->attribute_value->attribute->name]=$product_attributes->attribute_value->value;
            }
            }
            $i++;
        }
         return($data);
     }
}
