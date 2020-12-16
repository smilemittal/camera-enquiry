<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable=['name','type','display_order','system_type_id'];

    public function attribute_values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');
    }

    public function system_type()
    {
        return $this->belongsTo('App\Models\SystemType');
    }
}
