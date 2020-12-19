<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $fillable = ['products', 'quantity', 'system_type_id', 'standard_id'];

    public function system_type(){
        return $this->belongsTo('App\Models\SystemType', 'system_type_id', 'id');
    }
    public function standard(){
        return $this->belongsTo('App\Models\Standard', 'standard_id', 'id');
    }
}
