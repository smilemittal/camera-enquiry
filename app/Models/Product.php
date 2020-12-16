<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable=['name','type', 'system_type_id', 'standard_id'];

    public function product_attributes(){
        return $this->hasMany('App\Models\ProductAttribute', 'product_id', 'id');
    }
}
