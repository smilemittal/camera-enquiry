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

	public function product()
	{
	return $this->belongsTo('App\Models\Product','product_id', 'id');
	}

	public function attribute()
	{
	return $this->belongsTo('App\Models\Attribute','attribute_id', 'id')->orderBy('display_order', 'ASC');
	}

	public function attribute_value()
	{
	return $this->belongsTo('App\Models\AttributeValue','attribute_value_id', 'id');
	
	}
}
