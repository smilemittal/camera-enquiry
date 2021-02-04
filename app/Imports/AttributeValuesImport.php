<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\AttributeValue;
use App\Models\Attribute;
use App\Models\SystemType;
use App\Models\Type;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttributeValuesImport implements ToCollection, WithHeadingRow
{
    public $attribute_existing = 0;
    public $total_attributes = 0;
    public $attribute_imported = 0;
    public $total_attribute_value = 0;
    public $attribute_value_imported = 0;
    public $attribute_value_existing = 0;


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $description = '';
       $system_type_id = $type_id = ''; 
       $total_import_attributes = [];
       $already_existing_attributes = $imported_attributes = [];
       $this->total_attribute_value = count($rows);

       $existing_attribute_value = $imported_attribute_value = 0;
        
      foreach($rows as $row){
        
          if(!empty($row['attribute']) && $row['attribute'] != null){
            
              //get system type, if exists, get id, otherwise create new system type and get its id
            if(!empty($row['system_type'])){
                $system_type = SystemType::where('name', 'LIKE', $row['system_type'])->first();
             
                if($system_type){
                    $system_type_id = $system_type->id;
                }else{
                    $system_types = SystemType::create([
                        'name' => $row['system_type'],
                    ]);
                    $system_type_id = $system_types->id;
                }
            }

            if(!empty($row['type'])){
                $type = Type::where('name', 'LIKE', $row['type'])->first();
                if($type){
                    $type_id = $type->id;
                }else{
                    $types = Type::create([
                        'name' => $row['type'],
                    ]);
                    $type_id = $types->id;
                }
            }
            if(!empty($row['description'])){
                $description = $row['description'];
            }
          

             $attribute= Attribute::where('name','LIKE', $row['attribute'])->where('system_type_id','LIKE',   $system_type_id )->where('type_id', $type_id)->first();
            
              if(!$attribute)
              {
                $attributes = Attribute::create(['name' => $row['attribute'], 'type_id' => $type_id ,'display_order'=>$row['display_order'] , 'system_type_id' => $system_type_id , 'description' => $row['description']]);
                $attribute_id =$attributes->id;
                if(!in_array($attribute_id, $imported_attributes)){
                    $imported_attributes[] = $attribute_id;
                }
              }
              else
              {
                $attribute_id =$attribute->id;
                if(!in_array($attribute_id, $already_existing_attributes)){
                    $already_existing_attributes[] = $attribute_id;
                }
              }
              if(!in_array($attribute_id, $total_import_attributes)){
                $total_import_attributes[] = $attribute_id;
              }
              $display_order =$row['display_order'];

              $attribute_value_display_order = 0;
              $latest_attribute_value = AttributeValue::where('attribute_id', $attribute_id)->where('system_type_id' , '=', $system_type_id)->where('type_id', $type_id)->orderBy('id', 'DESC')->first();

              if($latest_attribute_value){
                  $attribute_value_display_order = $latest_attribute_value->display_order + 1;
              }else{
                  $attribute_value_display_order = $attribute_value_display_order + 1;
              }
            
                  $attribute_values= AttributeValue::where('attribute_id', $attribute_id)->where('value', 'LIKE', $row['attribute_value'])->where('system_type_id','LIKE', $system_type_id)->where('type_id','LIKE',$type_id)->first();

                  if(!$attribute_values){

                      $attribute_value = AttributeValue::create(['attribute_id' => $attribute_id, 'type_id' => $type_id ,'value' => $row['attribute_value'],'display_order'=>$attribute_value_display_order , 'system_type_id' => $system_type_id]);

                      $attribute_value_id =$attribute_value->id;

                    $imported_attribute_value++;
                     
                  }
                  else
                  {
                  $attribute_value_id =$attribute_values->id;
                  $existing_attribute_value++;
                  }
          }    
        }    
        $this->attribute_existing = count($already_existing_attributes);
        $this->total_attributes = count($total_import_attributes);
        $this->attribute_imported = count($imported_attributes);
        $this->attribute_value_imported = $imported_attribute_value;
        $this->attribute_value_existing = $existing_attribute_value;
    }
}
