<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Standard;
use App\Models\Attribute;
use App\Models\SystemType;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ProductAttributesImport implements ToCollection, WithHeadingRow 
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {

        foreach($rows as $row){
         
            if(!empty($row['model']) && $row['model'] != null){

                $display_order =$row['display_order'];
                $type = $row['type'];
        
                //get standard, if exists, get id, otherwise create new standard and get its id 
                $standard = Standard::where('name', 'LIKE', $row['standards'])->first();
                if($standard){
                    $standard_id = $standard->id;
                }else{
                    $standards = Standard::create([
                        'name' => $row['standards'],
                    ]);
                    $standard_id = $standards->id;
                }
                //get system type, if exists, get id, otherwise create new system type and get its id
                $system_type = SystemType::where('name', 'LIKE', $row['system_type'])->first();
                if($system_type){
                    $system_type_id = $system_type->id;
                }else{
                    $system_types = SystemType::create([
                        'name' => $row['system_type'],
                    ]);
                    $system_type_id = $system_types->id;
                }
                //get product, if exists, get id, otherwise create new product and get its id
                $product= Product::where('name','LIKE', $row['model'])->where('type', 'LIKE', $type)->where('system_type_id', $system_type_id)->where('standard_id', $standard_id)->first();

                if(!$product){
                    $products = Product::create(['name' => $row['model'], 'type' => $type, 'system_type_id' => $system_type_id, 'standard_id' => $standard_id]);
                    $product_id =$products->id;
                }else{
                    $product_id =$product->id;
                }
            
                foreach($row as $key => $value){
                    if($key != 'model' && $key != 'display_order' && $key != 'system_type' && $key != 'type' && $key != 'standards' && $value != null && $value != ''){

                    $attribute_display_order = 0;
                    $latest_attribute = Attribute::where('system_type_id' , '=', $system_type_id)->orderBy('id', 'DESC')->first();

                    if($latest_attribute){
                        $attribute_display_order = $latest_attribute->display_order + 1;
                    }else{
                        $attribute_display_order = $attribute_display_order + 1;
                    }
                    
                    $attribute = Attribute::where('name', 'LIKE', $key)->where( 'system_type_id' , '=', $system_type_id)->first();
                    if(!$attribute) {
                        $attribute = Attribute::create(['name' => $key ,'display_order'=> $attribute_display_order , 'system_type_id' => $system_type_id]);

                        $attribute_id =$attribute->id;
                    }else{
                        $attribute_id =$attribute->id;
                    }

                    $attribute_value_display_order = 0;
                    $latest_attribute_value = AttributeValue::where('system_type_id' , '=', $system_type_id)->orderBy('id', 'DESC')->first();

                    if($latest_attribute_value){
                        $attribute_value_display_order = $latest_attribute_value->display_order + 1;
                    }else{
                        $attribute_value_display_order = $attribute_value_display_order + 1;
                    }

                    $attribute_values= AttributeValue::where('attribute_id', $attribute_id)->where('value', 'LIKE', $value)->first();

                    if(!$attribute_values){
                        $attribute_value = AttributeValue::create(['attribute_id' => $attribute_id, 'value' => $value ,'display_order'=>$attribute_value_display_order , 'system_type_id' => $system_type_id]);

                        $attribute_value_id =$attribute_value->id;
                    }else{
                        $attribute_value_id =$attribute_values->id;
                    }

                    $product_attribute = ProductAttribute::create([
                                            'product_id' =>$product_id,
                                            'attribute_id' => $attribute_id,
                                            'attribute_value_id' => $attribute_value_id,
                                        ]);
                    }
                }
            }    
        }    
    }
}