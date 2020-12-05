<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class AttributeValue extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table='attribute_values';
    protected $fillable=['attribute_id','value','display_order','system_type_id'];
}
