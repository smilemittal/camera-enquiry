<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='product_attributes';
    protected $fillable=['product_id'];
    protected $fillable=['attribute_id'];
    protected $fillable=['attribute_value_id'];
}
