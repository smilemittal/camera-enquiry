<?php

namespace App\Imports;

use App\Models\AttributeValue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttributeValuesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new AttributeValue([
            'attribute_id' => $row['attribute_id'],
           'value'    => $row['value'], 
           'display_order' => $row['display_order'],
           'system_type_id' => $row['system_type_id'],
        ]);
    }
}
