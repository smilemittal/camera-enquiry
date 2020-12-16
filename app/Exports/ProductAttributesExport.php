<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductAttributesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
        
    }
}
