<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Attribute;
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
        foreach($attributes as $attribute){
            $data[0][$attribute->name] = $attribute->name; 
        }
        //dd($data);
         $products= Product::with('product_attributes.attribute_value')->get();
         $i=1;
         foreach($products as $product)
         {  
            $data[$i] =[
                'product' => $product->name,
            ];
            $value=[];
             foreach($product->product_attributes as $product_attribute){
                if(!empty($product_attribute->attribute_value) ){
                     $value[] = $product_attribute->attribute_value->value;    
               }else{
                $value[] ='';
               }  
            }
             $result[$i] = array_merge($data[$i],$value);
             $i++;
        }
           
               return($result);
     }
}
