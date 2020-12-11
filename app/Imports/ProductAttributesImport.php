<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;


class ProductAttributesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

           $product= Product::where('name','LIKE', $row['model']->first());
            if(!$product){
            $product_id = Product::create(['name' => $row['model']]);
            }else{
            $product_id =$product->id;
            }

            foreach($row as $key => $value)
            {
            if($key != 'model')
            {
            $attribute_values= AttributeValue::where('attribute_id', $key)->where('value', 'LIKE', $value)->first();
            return new ProductAttribute(
            [
            'product_id' =>$row('product_id'),
            'attribute_id' => $key('attribute_id'),
            'attribute_value_id ' => $row('attribute_value_id'),
            ]);
            }
            }
    }

}