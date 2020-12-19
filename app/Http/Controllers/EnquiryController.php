<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(){
        $enquiries = Enquiry::all();
        $enquiry_arr = [];
        foreach($enquiries as $key => $enquiry){
            $products = json_decode($enquiry->products, true);
            $quantity  = json_decode($enquiry->quantity, true);
            
            foreach($products as $product_type => $product){
                //dd($product);
                foreach($product as $no => $attributes){
                    if(!empty($quantities[$product_type][$no])){
                        $quantity_arr[$product_type][$no] = $quantities[$product_type][$no];
                    }
                }
            }
        }
    }
}
