<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Standard;
use App\Models\Type;
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

    public $importSuccess = false;
    public $products_imported = 0;
    public $row_count = 0;
    public $errors = [];
    public $already_existing = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
    // dd($rows);
  
  

    $this->row_count = count($rows);

    $import_count= $import_already_existing = 0;
    $import_errors = [];
        foreach($rows as $row){
          //dd($rows);
          $system_type_id = $type_id = $standard_id = $product_id = '';
            if(((!empty($row['Model'])&&$row['Model'] != null) || (!empty($row['Product name'])&& $row['Product name'] != null))){
                if(!empty($row['Model'])){
                    $product_name= trim($row['Model'], " ");
                }else{
                    $product_name= trim($row['Product name'], " ");
                }

                if(isset($row['Standards'])){
                    $standard_name= trim($row['Standards'], " ");
                }else if(isset($row['Standard'])){
                    $standard_name= trim($row['Standard'], " ");
                }
                // $type = $row['type'];

                if( (!empty($row['Type']) && $row['Type'] != null)){
                    $row_type = trim($row['Type'], " ");
                    $type = Type::where('name', 'LIKE', "%{$row_type}%")->first();
                    if($type){
                        $type_id = $type->id;
                    }else{
                        $types = Type::create([
                            'name' => $row_type,
                            'slug'=>  strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row_type))),
                        ]);
                        $type_id = $types->id;
                    }
                }else{
                    if(!in_array(__('message.Type is required.'), $import_errors)){
                        $import_errors[]= __('message.Type is required.');
                    }
                   
                }
             
                if( (!empty($row['System type']) && $row['System type'] != null)){
                    $row_sys_type = trim($row['System type'], " ");
                    //get system type, if exists, get id, otherwise create new system type and get its id
                    $system_type = SystemType::where('name', 'LIKE', "%{$row_sys_type}%")->first();
                    if($system_type){
                        $system_type_id = $system_type->id;
                    }else{
                        $system_types = SystemType::create([
                            'name' => $row_sys_type,
                        ]);
                        $system_type_id = $system_types->id;
                    }
                }else{
                    if(!in_array(__('message.System Type is required.'), $import_errors)){
                        $import_errors[]= __('message.System Type is required.');
                    }
                }

                if( !empty($standard_name) && $standard_name != null && !empty($system_type_id)){
                   
                    //get standard, if exists, get id, otherwise create new standard and get its id 
                    $standard = Standard::where('name', 'LIKE', $standard_name)->first();
                  
                    if($standard){
                        $standard_id = $standard->id;
                    }else{
                        $standards = Standard::create([
                            'name' => $standard_name,
                            'system_type_id' => $system_type_id,
                        ]);
                        $standard_id = $standards->id;
                    }
                }else{
                    if(!in_array(__('message.Standard is required.'), $import_errors)){
                        $import_errors[]= __('message.Standard is required.');
                    }
                }
               
                //get product, if exists, get id, otherwise create new product and get its id
               if($system_type_id != '' && $type_id != '' && $standard_id != ''){
                $price = 0.00;   
                if(!empty ($row['Price']) ){
                    $price = $row['Price'];
                }
                    $product= Product::where('name','LIKE', $product_name)->where('type_id', 'LIKE', $type_id)->where('system_type_id', $system_type_id)->where('standard_id', $standard_id)->where('priority','LIKE', trim($row['Priority'], " "))->first();

                    if(!$product){
                        $products = Product::create(['name' => $product_name, 'type_id' => $type_id, 'system_type_id' => $system_type_id, 'standard_id' => $standard_id,'priority' => trim($row['Priority'], " "),'price' => $price]);
                        $product_id =$products->id;
                        $product_type = $products->type_id;
                        $import_count++;
                    
                    }else{
                        $product_id =$product->id;
                        $product_type = $product->type_id;
                        $import_already_existing++;
                    }
                    if($import_count > 0){
                    
                        $this->importSuccess = true;
                    }
                }
               
                foreach($row as $key => $value){
                    $key = trim($key, " ");
                    $value = trim($value, " ");

                    if(($key != 'Model' && $key != 'Product name') && $key != 'Display order' && $key != 'Priority' && $key != 'System type' && $key != 'Type' && ($key != 'Standards' && $key != 'Standard') && $value != null && $value != '' && $system_type_id != '' && $type_id != '' && $standard_id != ''){
          // dd($row['System type'], $standard_id, $type_id, $system_type_id, $this->products_imported);
                    $attribute_display_order = 0;
                    $latest_attribute = Attribute::where('system_type_id' , '=', $system_type_id)->where('type_id', $type_id)->orderBy('id', 'DESC')->first();

                    if($latest_attribute){
                        $attribute_display_order = $latest_attribute->display_order + 1;
                    }else{
                        $attribute_display_order = $attribute_display_order + 1;
                    }
                    
                    $attribute = Attribute::where('name', 'LIKE', $key)->where( 'system_type_id' , '=', $system_type_id)->where('type_id', $type_id)->first();
                    if(!$attribute) {
                        $attribute = Attribute::create(['name' => $key ,'display_order'=> $attribute_display_order , 'system_type_id' => $system_type_id, 'type_id'=> $type_id]);

                        $attribute_id =$attribute->id;
                    }else{
                        $attribute_id =$attribute->id;
                    }

                    $attribute_value_display_order = 0;
                    $latest_attribute_value = AttributeValue::where('attribute_id', $attribute_id)->where('system_type_id' , '=', $system_type_id)->where('type_id', $type_id)->orderBy('id', 'DESC')->first();

                    if($latest_attribute_value){
                        $attribute_value_display_order = $latest_attribute_value->display_order + 1;
                    }else{
                        $attribute_value_display_order = $attribute_value_display_order + 1;
                    }

                    $attribute_values= AttributeValue::where('attribute_id', $attribute_id)->where('value', 'LIKE', $value)->where('type_id', $type_id)->first();

                    if(!$attribute_values){
                        $attribute_value = AttributeValue::create(['attribute_id' => $attribute_id, 'value' => $value ,'display_order'=>$attribute_value_display_order , 'system_type_id' => $system_type_id ,'type_id'=> $type_id]);

                        $attribute_value_id =$attribute_value->id;
                    }else{
                        $attribute_value_id =$attribute_values->id;
                    }

                   
                  
                   
                   
                    $product_attribute = ProductAttribute::create([
                                            'product_id' =>$product_id,
                                            'attribute_id' => $attribute_id,
                                            'attribute_value_id' => $attribute_value_id,
                                        ]);
                      //dd($product_attribute);
                    }


                }
            }    
        }   
        $this->products_imported = $import_count;
        $this->errors = $import_errors;
        $this->already_existing = $import_already_existing;
        
        
      
    }
}