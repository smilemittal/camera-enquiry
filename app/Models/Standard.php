<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Standard extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='standards';
    protected $fillable=['name','system_type_id'];
    public function system_type(){
        return $this->belongsTo('App\Models\SystemType', 'system_type_id', 'id');
    }
}

