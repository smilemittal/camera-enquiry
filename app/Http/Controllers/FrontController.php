<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Standard;
use App\Models\Attribute;
use App\Models\SystemType;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Validator;
use PDF;


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
          //  dd($standard);
            $attribute_camera = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type', 'camera')->orderBy('display_order', 'ASC')->get();
            $attribute_recorder = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type', 'recorder')->orderBy('display_order', 'ASC')->get();
            //dd($attribute_recorder);
            $html_camera = $html_recorder = '';

            $i = 1;
            $html_camera .= view('frontend.extras.filter', compact('attribute_camera', 'system_type', 'i'))->render();
            $html_recorder .= view('frontend.extras.filter', compact('attribute_recorder', 'system_type', 'i'))->render();

         

            return response()->json(['success'=> true, 'html_camera' => $html_camera, 'html_recorder' => $html_recorder, 'count'=> $i]);
            
        }
    }

    public function updateAttributes(Request $request){
        if($request->ajax() && $request->isMethod('post')){
            $system_type = $request->input('system_type');
            $product_type = $request->input('product_type');
            $count = $request->input('count');
            //dd($product_type);
            
            $attribute_value_id = $request->input('attribute_value');
            $attribute_value_id = explode(',', $attribute_value_id);
        

            $products = Product::with('product_attributes', 'product_attributes.attribute.attribute_values', 'product_attributes.attribute_value')
                            ->whereHas('product_attributes.attribute', function($q)use($product_type){
                                $q->where('type', $product_type);
                            });
                           

                            if(is_array($attribute_value_id)){
                                foreach($attribute_value_id as $id){
                                    $products->whereHas('product_attributes', function($q) use($id){
                                        $q->where('attribute_value_id', $id);
                                
                                    });
                                }
                            }else{
                                $products->whereHas('product_attributes', function($q) use($attribute_value_id){
                                    $q->where('attribute_value_id', $attribute_value_id);
                            
                                });
                            
                            }

            $products->whereHas('product_attributes.attribute', function($q){
                            $q->orderBy('display_order', 'ASC');
                        });
                          
            $products = $products->get();
            //dd($products);
                    
            $attributes=$display_order = [];

            if(!empty($products) && count($products) > 0){

                foreach($products as $product){
                
                    if(!empty($product->product_attributes)){
                    
                        foreach($product->product_attributes as $product_attribute){

                            if(!empty($product_attribute) && !empty($product_attribute->attribute)){
                                $attribute_values = [];
                                foreach($product_attribute->attribute->attribute_values as $attribute_value){
                                
                                    if(!in_array_r($product_attribute->attribute->id, $attributes)){
                                        
                                            $attribute_values[$attribute_value->id] = $attribute_value->value;
                                        // dd('has', $attribute_values );
                                        $attributes[$product_attribute->attribute_id] = ['attribute_name' => $product_attribute->attribute->name, 'attribute_values' => $attribute_values];
                                    }else{
                                    // dd('hs not');
                                        if(!in_array_r($attribute_value->id,  $attributes[$product_attribute->attribute_id]['attribute_values'])){
                                            $attribute_values[$attribute_value->id] = $attribute_value->value;
                                            $attributes[$product_attribute->attribute_id] = ['attribute_name' => $product_attribute->attribute->name, 'attribute_values' => $attribute_values];
                                        } 
                                    }
                                } 
                                $attribute_values = [];

                            }
                        }
                    } 
                }   
           //dd($attributes[189]);
            }else{

                $fetch_attributes = Attribute::with('attribute_values')->where('type', $product_type);
            
                $fetch_attributes->whereHas('attribute_values', function($q) use($attribute_value_id){
                    $q->whereIn('id', $attribute_value_id);
            
                });

                $fetch_attributes = $fetch_attributes->orderBy('display_order', 'ASC')->get();
        
                foreach($fetch_attributes as $attribute){
            
                    foreach($attribute->attribute_values as $attribute_value){
                    
                        if(!in_array_r($attribute->id, $attributes)){
                                $attribute_values[$attribute_value->id] = $attribute_value->value;
                        }else{
                            if(!in_array_r($attribute_value->id,  $attributes[$attribute->id]['attribute_values'])){
                                $attribute_values[$attribute_value->id] = $attribute_value->value;
                            } 
                        }
                    } 
                    $attributes[$attribute->id] = ['attribute_name' => $attribute->name, 'attribute_values' => $attribute_values];
                    $attribute_values = [];
                }            
            }
           // dd($attributes);
    
            $html='';
            
            $i = $count;
            
            $html .= view('frontend.extras.filter', compact('attributes', 'system_type', 'product_type', 'attribute_value_id', 'i'))->render();

            return response()->json(['success' => true, 'html' => $html, 'product_type' => $product_type]);
        }
    }

    public function getNextProduct(Request $request){
        if($request->ajax() && $request->isMethod('post')){

            $system_type = $request->input('system_type');
            $standard = $request->input('standard');
            $product_type = $request->input('product_type');
            $count = $request->input('count');
            $i = $count+1;


            $attributes_new_product = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type', $product_type)->get();
          
            $html = $attribute_html = '';

           
            $attribute_html .= view('frontend.extras.filter', compact('attributes_new_product', 'system_type', 'i', 'product_type'))->render();
       
            $html .= view('frattribute_recorderontend.extras.new-type', compact('attribute_html', 'system_type', 'i', 'product_type'))->render();
       
           // dd($html_recorder);

            return response()->json(['success'=> true, 'html' => $html, 'count'=> $i]);
                

        }
    }
    
    public function saveEnquiry(Request $request){
        //dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'quantity.*.*' => 'required',
        //     'products.*.*' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['success'=> false, 'errors' => $validator->errors()]);
        // }

        
        $quantities = $request->input('quantity');
        $products = $request->input('products');
        $standard_id = $request->input('selected_standard');
        $system_type_id = $request->input('selected_system_type');
        $quantity_arr = [];
        $product_arr = [];
        foreach($products as $product_type => $product){
      
            foreach($product as $no => $attributes){

                foreach($attributes as $key => $attribute){
                   // dd($attribute);
                    if($attribute != NULL){
                       // dd($quantities[$product_type][$no]);
                        $product_arr[$product_type][$no][] = $attribute;
                      
                        
                    }
                   
                }
                if(!empty($quantities[$product_type][$no])){
                    $quantity_arr[$product_type][$no] = $quantities[$product_type][$no];
                }
               
            }   

        }

        $product_arr = json_encode($product_arr);
        $quantity_arr = json_encode($quantity_arr);

        $enquiry = Enquiry::create([
            'products' => $product_arr,
            'quantity' => $quantity_arr,
            'standard_id' => $standard_id,
            'system_type_id' => $system_type_id,
        ]);
        if($enquiry){
            return response()->json(['success'=> true, 'message'  => 'Enquiry Sent Successfully']);
        }else{
            return response()->json(['success'=> false, 'message'  => 'Failed Sending enquiry! Try again']);
        }
        

    }

    public function printEnquiry(Request $request){
        $quantities = $request->input('quantity');
        $products = $request->input('products');
        $standard_id = $request->input('selected_standard');
        $system_type_id = $request->input('selected_system_type');
        $quantity_arr = [];
        $product_arr = [];
        foreach($products as $product_type => $product){
      
            foreach($product as $no => $attributes){

                foreach($attributes as $key => $attribute){
                   // dd($attribute);
                    if($attribute != NULL){
                       // dd($quantities[$product_type][$no]);
                        $product_arr[$product_type][$no][] = $attribute;
                      
                        
                    }
                   
                }
                if(!empty($quantities[$product_type][$no])){
                    $quantity_arr[$product_type][$no] = $quantities[$product_type][$no];
                }
               
            }   

        }

        $product_arr = ($product_arr);
        $quantity_arr = ($quantity_arr);



            // $data = [
            //    'products' => $product_arr, 
            //    'quantities' => $quantity_arr,
            // ];

            $products = $product_arr;
            $quantities = $quantity_arr;

            $html = view('enquiries.partials.pdf', compact('products', 'quantities'))->render();
            return response()->json(['success' => true, 'html' => $html]);
        
    }



}
