<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Standard;
use App\Mail\EnquiryMail;
use App\Models\Attribute;
use App\Models\SystemType;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class FrontController extends Controller
{
    public function changeLanguage(Request $request)
    {
    	$request->session()->put('locale', $request->locale);
    }
    public function home(){
        $system_types = SystemType::orderBy('id', 'ASC')->get();
        $standards = Standard::orderBy('id', 'ASC')->get();
        return view('frontend.home', compact('standards', 'system_types'));
    }

    public function updateAttributes(Request $request){
        if($request->ajax() && $request->isMethod('post')){
            $system_type = $request->input('system_type');
            $product_type = $request->input('product_type');
            $type = Type::where('slug','LIKE',$product_type)->first();
            $count = $request->input('count');
            $attribute_value_id = $request->input('attribute_value');
            $attribute_value_id = explode(',', $attribute_value_id);
            $selected_attributes = $request->input('selected_attributes');

            $products = Product::with('product_attributes', 'product_attributes.attribute.attribute_values', 'product_attributes.attribute_value')
                        ->whereHas('product_attributes.attribute', function($q)use($type){
                            $q->where('type_id', $type->id);
                        });


            foreach($attribute_value_id as $id){
                if($id != 'unimportant'){
                    $products->whereHas('product_attributes', function($q) use($id){
                        $q->where('attribute_value_id', $id);
                    });
                }

            }

            $products = $products->where('system_type_id', $system_type)->where('type_id', $type->id)->get();

            $attributes = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type_id', $type->id)->orderBy('display_order', 'ASC')->get();
            $filtered_attributes = array();
            if(!empty($products) && count($products) > 0){
                foreach($products as $product){

                    if(!empty($product->product_attributes)){
                        foreach($product->product_attributes as $product_attribute){
                            $filtered_attributes[$product_attribute->attribute_id][] = $product_attribute->attribute_value_id;
                        }
                    }
                }
            }
            $html='';

            $i = $count;

            $html .= view('frontend.extras.filter', compact('filtered_attributes', 'system_type', 'type', 'selected_attributes','attributes', 'i'))->render();
            return response()->json(['success' => true, 'html' => $html, 'product_type' => $product_type]);
        }
    }

    public function getNextProduct(Request $request){
        if($request->ajax() && $request->isMethod('post')){
            $system_type = $request->input('system_type');
            $standard = $request->input('standard');
            $product_type = $request->input('product_type');
            $type= Type::where('slug','LIKE',$product_type)->first();
            $count = $request->input('count');
            $i = $count+1;

            $attributes = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type_id', $type->id)->get();

            $html = $attribute_html = '';

            $attribute_html .= view('frontend.extras.filter', compact('attributes', 'system_type', 'i', 'type'))->render();

            $html .= view('frontend.extras.new-type', compact('attribute_html', 'system_type', 'i', 'type'))->render();

            return response()->json(['success'=> true, 'html' => $html, 'count'=> $i]);
        }
    }

    public function saveEnquiry(Request $request)
    {
        $quantities = $request->input('quantity');
        $total_qtys = $request->input('total_qty');
        $products = $request->input('products');
        $standard_id = $request->input('selected_standard');
        $system_type_id = $request->input('selected_system_type');
        $quantity_arr = [];
        $product_arr = [];
        $total_products = 0;
        if(!empty($products))
        {
            foreach($products as $product_type => $product){
                $quantity_total = 0;

                foreach($product as $no => $attributes){

                    foreach($attributes as $key => $attribute){
                        if($attribute != NULL){
                            $product_arr[$product_type][$no][$key] = $attribute;
                        }
                    }
                    if(!empty($quantities[$product_type][$no])){
                        $quantity_arr[$product_type][$no]['qty'] = $quantities[$product_type][$no];
                        $quantity_arr[$product_type][$no]['total_qty'] = $total_qtys[$product_type][$no];
                        $quantity_total += (int)$total_qtys[$product_type][$no];
                    }
                }
                $quantity_arr[$product_type]['total'] = $quantity_total;
                $total_products += $quantity_total;
            }
        }

        if($total_products > 0){

            $product_arr = json_encode($product_arr);
            $quantity_arr = json_encode($quantity_arr);
            $enquiry = Enquiry::create([
                'products' => $product_arr,
                'quantity' => $quantity_arr,
                'standard_id' => $standard_id,
                'system_type_id' => $system_type_id,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'company' => $request->input('company'),
                'mobile_no' => $request->input('mobile_no'),

            ]);
            if($enquiry){
                $products = json_decode($product_arr, true);
                $quantities = json_decode($quantity_arr, true);
                Mail::to(config('app.admin_email'))->send(new EnquiryMail($products, $quantities, $enquiry));

                return response()->json(['success'=> true, 'message'  => __('message.Enquiry Sent Successfully')]);
            }else{
                return response()->json(['success'=> false, 'message'  => __('message.Failed Sending enquiry! Try again')]);
            }
        }else{
            return response()->json(['success' => false, 'message' => 'Please Enter Quantity for the products.']);
        }


    }
    public function printEnquiry(Request $request){
        $quantities = $request->input('quantity');
        $total_qtys = $request->input('total_qty');
        $products = $request->input('products');
        $standard_id = $request->input('selected_standard');
        $system_type_id = $request->input('selected_system_type');
        $quantity_arr = [];
        $product_arr = [];
        $total_products = 0;
        foreach($products as $product_type => $product){
            $quantity_total = 0;

            foreach($product as $no => $attributes){

                foreach($attributes as $key => $attribute){
                    if($attribute != NULL){
                        $product_arr[$product_type][$no][$key] = $attribute;
                    }
                }
                if(!empty($quantities[$product_type][$no])){
                    $quantity_arr[$product_type][$no]['qty'] = $quantities[$product_type][$no];
                    $quantity_arr[$product_type][$no]['total_qty'] = $total_qtys[$product_type][$no];
                    $quantity_total += (int)$total_qtys[$product_type][$no];
                }
            }
            $quantity_arr[$product_type]['total'] = $quantity_total;
            $total_products += $quantity_total;
        }
        if($total_products > 0){
            $products = $product_arr;
            $quantities = $quantity_arr;

            $html = view('enquiries.partials.pdf', compact('products', 'quantities'))->render();
            return response()->json(['success' => true, 'html' => $html]);
        }else{
            return response()->json(['success' => false, 'message' => 'Please Enter Quantity for the products.']);
        }



    }
    public function getStandard(Request $request){
        if($request->ajax() && $request->isMethod('post')){
            $system_type = $request->input('system_type_id');
            $standard_attribute='';
            $standards = Standard::where('system_type_id', $system_type)->get();
            $standard_attribute .= view('frontend.extras.standard', compact('standards'))->render();
            $html = [];
            $i = 1;
            $types = Type::get();
            foreach($types as $type) {
                $attributes = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type_id', $type->id)->orderBy('display_order', 'ASC')->get();
                $attribute_html = view('frontend.extras.filter', compact('attributes', 'system_type', 'i', 'type'))->render();
                $html[$type->slug] = view('frontend.extras.new-type', compact('attributes', 'system_type', 'i', 'type', 'attribute_html'))->render();
            }
            return response()->json(['success'=> true, 'standard_attribute' => $standard_attribute, 'html' => $html, 'count'=> $i]);

        }
    }



}
