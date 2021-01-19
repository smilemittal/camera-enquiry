<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable=['name','type_id','display_order','system_type_id','description'];

    public function attribute_values(){
        return $this->hasMany('App\Models\AttributeValue', 'attribute_id', 'id')->orderBy('display_order', 'ASC');
    }

    public function system_type()
    {
        return $this->belongsTo('App\Models\SystemType');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }
}
