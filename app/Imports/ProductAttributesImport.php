<?php

namespace App\Imports;

use App\ProductAttribute;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductAttributesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = Product::where('name', 'LIKE', $row['model'])->first();
        
        AttributeValue::create($request->all());

        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Series of equipment');
        })->where('value', 'LIKE', $row['series_of_equipment'])->first();

        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Number of channels');
        })->where('value', 'LIKE', $row['number_of_channels'])->first();

        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'PoE channels');
        })->where('value', 'LIKE', $row['poe_channels'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'HDD Slots');
        })->where('value', 'LIKE', $row['hdd_slots'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Resolution');
        })->where('value', 'LIKE', $row['resolution'])->first();

        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Video Output');
        })->where('value', 'LIKE', $row['video_output'])->first();

        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Audio');
        })->where('value', 'LIKE', $row['audio'])->first();

        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Alarm');
        })->where('value', 'LIKE', $row['alarm'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Housing');
        })->where('value', 'LIKE', $row['housing'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Port Ethernet');
        })->where('value', 'LIKE', $row['port_ethernet'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Bitrate in');
        })->where('value', 'LIKE', $row['bitrate_in'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Bitrate out');
        })->where('value', 'LIKE', $row['bitrate_out'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'USB');
        })->where('value', 'LIKE', $row['usb'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'RS485');
        })->where('value', 'LIKE', $row['rs485'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Priority');
        })->where('value', 'LIKE', $row['priority'])->first();
        
        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Price nett');
        })->where('value', 'LIKE', $row['price_nett'])->first();

        $attribute_value[] = AttributeValue::with('system_type', 'attribute')
        ->whereHas('attribute', function($q)
        {
            $q->where('name', 'LIKE', 'Price with Tax');
        })->where('value', 'LIKE', $row['price_with_tax'])->first();


    foreach($attribute_value as $value){
        
    }
        return new ProductAttribute
        ([
            ([
           'series_of_equipment' => $row['series_of_equipment'],
           'number_of_channels'    => $row['number_of_channels'], 
           'poe_channels' => $row['poe_channels'],
           'hdd_slots' => $row['hdd_slots'],
           'video_output'=>$row['video_output'],
           'audio'=>$row['audio'],
           'alarm'=>$row['alarm'],
           'housing'=>$row['housing'],
           'port_ethernet'=>$row['port_ethernet'],
           'bitrate_in'=>$row['bitrate_in'],
           'bitrate_out'=>$row['bitrate_out'],
           'usb'=>$row['usb'],
           'rs485'=>$row['rs485'],
           'priority'=>$row['priority'],
           'price_nett'=>$row['price_nett'],
           'price_with_tax'=>$row['price_with_tax'],
        ]);
            
        ]);
    }
}
