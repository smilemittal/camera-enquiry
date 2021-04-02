<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table='currencies';
    protected $fillable=['name','symbol','exchange_rate','status','code', 'is_default'];

    public const STATUS = [
        0 => 'In-active',
        1 => 'Active',
    ];
}
