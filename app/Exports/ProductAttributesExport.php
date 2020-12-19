<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\Standard;
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
         $j=1;
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
            $standards= Standard::all();
             foreach($standards as $standard){
                 $data[$j] =[
                     'name' => $standard->name,
                 ];
             }
             $result[$i] = array_merge($data[$i],$value,$data[$j]);
             $i++;
             
        }
      // dd($result);
               return($result);
     }
}
