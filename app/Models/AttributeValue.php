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
    protected $fillable=['attribute_id','value','display_order','system_type_id', 'type_id'];

    public function system_type()
    {
        return $this->belongsTo('App\Models\SystemType','system_type_id', 'id');
    }

    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute','attribute_id', 'id');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\Type','type_id', 'id');
    }

}
