<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductAttribute extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='product_attributes';
    protected $fillable=['product_id','attribute_id','attribute_value_id'];
}
