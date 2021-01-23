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
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
     
        
      foreach($rows as $row){

          if(!empty($row['attribute']) && $row['attribute'] != null){
            
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
              $type = Type::where('name', 'LIKE', $row['type'])->first();
              if($type){
                  $type_id = $type->id;
              }else{
                  $types = Type::create([
                      'name' => $row['type'],
                  ]);
                  $type_id = $types->id;
              }
            $description = $row['description'];
             $attribute= Attribute::where('name','LIKE', $row['attribute'])->where('system_type_id','LIKE',   $system_type_id )->first();
            
              if(!$attribute)
              {
                $attributes = Attribute::create(['name' => $row['attribute'], 'type_id' => $type_id ,'display_order'=>$row['display_order'] , 'system_type_id' => $system_type_id , 'description' => $row['description']]);
                $attribute_id =$attributes->id;
              }
              else
              {
                $attribute_id =$attribute->id;
              }
              $display_order =$row['display_order'];
              $system_type = $row['system_type'];
            
                  $attribute_values= AttributeValue::where('attribute_id', $attribute_id)->where('value', 'LIKE', $row['attribute_value'])->where('system_type_id','LIKE', $system_type_id)->where('type_id','LIKE',$type_id)->first();

                  if(!$attribute_values){

                      $attribute_value = AttributeValue::create(['attribute_id' => $attribute_id, 'type_id' => $type_id ,'value' => $row['attribute_value'],'display_order'=>$row['display_order'] , 'system_type_id' => $system_type_id]);

                      $attribute_value_id =$attribute_value->id;
                     
                  }
                  else
                  {
                  $attribute_value_id =$attribute_values->id;
                  }
          }    
        }    
        
    }
}
