<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Standard;
use App\Models\Attribute;
use App\Models\SystemType;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    
    public function home(){
        $system_types = SystemType::all();
        $standards = Standard::all();
        return view('frontend.home', compact('standards', 'system_types'));
    }

    public function getEnquiryProductAttributes(Request $request){
        if($request->ajax() && $request->isMethod('post')){
            $system_type = $request->input('system_type');
            $standard = $request->input('standard');

            $attribute = Attribute::where('system_type_id', $system_type)->get();
            $product = Product::with('product_attributes.attribute.attribute_values')->where('system_type_id', $system_type)->where('standard', $standard)->get();

            $html = '';
            $html .= view('frontend.extras.filter', compact('product'))->render();
        }
    }



}
