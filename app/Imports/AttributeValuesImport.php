<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\AttributeValue;
use App\Models\Attribute;
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

          if(!empty($row['name']) && $row['name'] != null){

             $attribute= Attribute::where('name','LIKE', $row['name'])->where('system_type_id','LIKE', $row['system_type_id'])->first();

              if(!$attribute)
              {
                $attributes = Attribute::create(['name' => $row['name'], 'type' => $row['type'] ,'display_order'=>$row['display_order'] , 'system_type_id' => $row['system_type_id']]);
                $attribute_id =$attributes->id;
              }
              else
              {
                $attribute_id =$attribute->id;
              }
              $display_order =$row['display_order'];
              $system_type_id = $row['system_type_id'];
                  $attribute_values= AttributeValue::where('attribute_id', $attribute_id)->where('value', 'LIKE', $row['value'])->where('system_type_id','LIKE', $row['system_type_id'])->first();

                  if(!$attribute_values){

                      $attribute_value = AttributeValue::create(['attribute_id' => $attribute_id, 'value' => $row['value'],'display_order'=>$row['display_order'] , 'system_type_id' => $row['system_type_id']]);

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
