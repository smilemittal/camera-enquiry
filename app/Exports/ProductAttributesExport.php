<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\Standard;
use App\Models\SystemType;
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
        $data[0] =['product' => 'Product']; 
        foreach($attributes as $attribute){
            $data[0][$attribute->id] = $attribute->name; 
        }
        //dd($data);
         $products= Product::with('product_attributes.attribute_value')->get();
         $i=1;
         $j=1;
         foreach($products as $product)
         {  
            $data[$i] =[
                'product' => $product->name,
                'standards'=>$product ->name,
                'system_types' =>$product->name,

            ];
    
        }
       
       
     // dd($data);
               return($data);
     }
}
