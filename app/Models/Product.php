<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable=['name','type_id', 'system_type_id', 'standard_id'];

    public function product_attributes(){
        return $this->hasMany('App\Models\ProductAttribute', 'product_id', 'id');
    }
    public function standards(){
        return $this->belongsTo('App\Models\Standard', 'standard_id', 'id');
    }
    public function system_types(){
        return $this->belongsTo('App\Models\SystemType', 'system_type_id', 'id');
    }
    public function types(){
        return $this->belongsTo('App\Models\Type','type_id', 'id');
    }
   
}
