<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
   protected $table = 'languages';

   protected $fillable = ['name','code','rtl', 'is_default', 'default_currency_id'];
}
