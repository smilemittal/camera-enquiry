<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ProductAttributesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(collection $rows)
    {
        foreach($rows as $row){


        if(!empty($row['model']) && $row['model'] != null){


           $product= Product::where('name','LIKE', $row['model'])->first();

            if(!$product)
            {
            $products = Product::create(['name' => $row['model']]);
            $product_id =$products->id;
            }else{
            $product_id =$product->id;
            }
            $display_order =$row['display_order'];
            $system_type_id = $row['system_type_id'];
            foreach($row as $key => $value)
            {
                if($key != 'model' && $key != 'display_order' && $key != 'system_type_id')
                {
                
                $attribute_values= AttributeValue::where('attribute_id', $key)->where('value', 'LIKE', $value)->first();
                 if(!$attribute_values)
                {
                $attribute_value = AttributeValue::create(['attribute_id' => $key, 'value' => $value ,'display_order'=>$display_order , 'system_type_id' => $system_type_id]);

                 $attribute_value_id =$attribute_value->id;
                }
                else
                {
                $attribute_value_id =$attribute_values->id;
                }
                $results[] =[
                'product_id' =>$product_id,
                'attribute_id' => $key,
                'attribute_value_id' => $attribute_value_id,
                ];

            $product_attribute = ProductAttribute::create(
                [
                'product_id' =>$product_id,
                'attribute_id' => $key,
                'attribute_value_id' => $attribute_value_id,
                ]);
                }

            }
        }    
        }    
    }

}