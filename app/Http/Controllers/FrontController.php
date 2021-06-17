<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Standard;
use App\Mail\EnquiryMail;
use App\Models\Attribute;
use App\Models\SystemType;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{

    public function __construct()
    {
        if (\Session::has('default_currency')) {
            $default_currency = \Session::get('default_currency');
        } else {
            $default_currency = default_currency();
        }
        \Session::put('default_currency', $default_currency);
    }
    public function changeLanguage(Request $request)
    {
        $request->session()->put('locale', $request->locale);
    }

    public function changeCurrency(Request $request)
    {
        $request->session()->put('default_currency', $request->default_currency);
    }
    public function home()
    {
        $system_types = SystemType::orderBy('id', 'ASC')->get();
        $standards = Standard::orderBy('id', 'ASC')->get();
        return view('frontend.home', compact('standards', 'system_types'));
    }

    public function updateAttributes(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $system_type = $request->input('system_type');
            $product_type = $request->input('product_type');
            $type = Type::where('slug', 'LIKE', $product_type)->first();
            $count = $request->input('count');
            $attribute_value_id = $request->input('attribute_value');

            $attribute_value_id = explode(',', $attribute_value_id);
            $selected_attributes = $request->input('selected_attributes');
            // dd($selected_attributes);
            $standard = $request->input('standard');

            //dd($attribute_value_id);
            $products = Product::with('product_attributes', 'product_attributes.attribute.attribute_values', 'product_attributes.attribute_value')
                ->whereHas('product_attributes.attribute', function ($q) use ($type) {
                    $q->where('type_id', $type->id);
                });


            foreach ($attribute_value_id as $id) {
                if ($id != 'unimportant' && $id != '') {
                    $products->whereHas('product_attributes', function ($q) use ($id) {
                        $q->where('attribute_value_id', $id);
                    });
                }
            }
            $get_product_query = $products;
            //dd($get_product_query->where('system_type_id', $system_type)->where('type_id', $type->id)->get(), $system_type, $type->id);




            $products = $products->where('system_type_id', $system_type)->where('type_id', $type->id)->get();

            $get_product = $get_product_query->where('system_type_id', $system_type)->where('type_id', $type->id)->orderBy('priority', 'ASC')->orderBy('created_at', 'ASC')->first();

            $pro_attrs = ProductAttribute::with('attribute')->where('product_id', $get_product->id)->whereHas('attribute', function ($q) {
                $q->where('name', 'LIKE', 'Series of Equipment');
            })->first();
            $pro_series = ($pro_attrs->attribute_value->value);
            $attribute_names = [];
            //dd($products);
            $attributes = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type_id', $type->id)->orderBy('display_order', 'ASC')->get();
            $filtered_attributes = array();
            if (!empty($products) && count($products) > 0) {
                foreach ($products as $product) {

                    if (!empty($product->product_attributes)) {
                        foreach ($product->product_attributes as $product_attribute) {


                            //get product series
                            // $product_attribute_value = AttributeValue::find($product_attribute->attribute_id);
                            // if(!empty($product_attribute_value)){
                            //     if(!empty($product_attribute_value->attribute)){
                            //         $product_attribute_name = $product_attribute_value->attribute->name;
                            //         if($product_attribute_name == 'Series of equipment'){
                            //             if(!in_array($product_attribute_value->value, $attribute_names)){
                            //                 $attribute_names[] = $product_attribute_value->value;
                            //             }

                            //          }
                            //     }
                            // }

                            // if(!empty($product_attribute->attribute) && $product_attribute->attribute->name == 'Series of Equipment'){
                            //     dd($product_attribute->attribute_value->value);
                            // }

                            $filtered_attributes[$product_attribute->attribute_id][] = $product_attribute->attribute_value_id;
                        }
                    }
                }
            }
            //dd($attribute_names);

            //get product series
            // if(count($attributes) == 1){
            //     $select_product = $get_product->product_attributes()->whereHas('attribute', function($q){
            //         $q->where('name', '=', 'Series of equipment');
            //     })->get();
            //   //  dd($select_product);
            // }
            $html = '';

            $i = $count;
            $html .= view('frontend.extras.filter', compact('filtered_attributes', 'system_type', 'type', 'selected_attributes', 'attributes', 'i', 'standard'))->render();
            return response()->json(['success' => true, 'html' => $html, 'product_type' => $product_type, 'pro_series' => $pro_series]);
        }
    }

    public function getNextProduct(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $system_type = $request->input('system_type');
            $standard = $request->input('standard');
            $product_type = $request->input('product_type');
            $type = Type::where('slug', 'LIKE', $product_type)->first();
            $count = $request->input('count');
            $i = $count + 1;

            $attributes = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type_id', $type->id)->get();

            $html = $attribute_html = '';

            $attribute_html .= view('frontend.extras.filter', compact('attributes', 'system_type', 'i', 'type', 'standard'))->render();

            $html .= view('frontend.extras.new-type', compact('attribute_html', 'system_type', 'i', 'type'))->render();

            return response()->json(['success' => true, 'html' => $html, 'count' => $i]);
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
        if (!empty($products)) {
            foreach ($products as $product_type => $product) {
                $quantity_total = 0;

                foreach ($product as $no => $attributes) {
                    $type = Type::where('slug', 'LIKE', $product_type)->first();

                    $model = Product::whereHas('product_attributes.attribute', function ($q) use ($type) {
                        $q->where('type_id', $type->id);
                    });
                    foreach ($attributes as $key => $attribute) {
                        if ($attribute != NULL) {
                            $product_arr[$product_type][$no][$key] = $attribute;
                        }
                        if ($attribute != 'unimportant') {
                            $model->whereHas('product_attributes', function ($q) use ($attribute) {
                                $q->where('attribute_value_id', $attribute);
                            });
                        }
                    }
                    $model = $model->select('name', 'price')->where('system_type_id', $system_type_id)->where('type_id', $type->id)->where('standard_id', $standard_id)->orderBy('priority', 'DESC')->first()->toArray();
                    $product_arr[$product_type][$no]['model'] = $model;

                    if (!empty($quantities[$product_type][$no])) {
                        $quantity_arr[$product_type][$no]['qty'] = $quantities[$product_type][$no];
                        $quantity_arr[$product_type][$no]['total_qty'] = $total_qtys[$product_type][$no];
                        $quantity_total += (int)$total_qtys[$product_type][$no];
                    }
                }
                $quantity_arr[$product_type]['total'] = $quantity_total;
                $total_products += $quantity_total;
            }
        }

        if ($total_products > 0) {

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
            if ($enquiry) {
                $products = json_decode($product_arr, true);
                $quantities = json_decode($quantity_arr, true);
                //Mail::to(config('app.admin_email'))->send(new EnquiryMail($products, $quantities, $enquiry)); 
                Mail::to(config('app.admin_email'))->send(new EnquiryMail($products, $quantities, $enquiry));
                return response()->json(['success' => true, 'message'  => translate('Enquiry Sent Successfully')]);
            } else {
                return response()->json(['success' => false, 'message'  => translate('Failed Sending enquiry! Try again')]);
            }
        } else {
            return response()->json(['success' => false, 'message' => translate('Please Enter Quantity for the products.')]);
        }
    }
    public function printEnquiry(Request $request)
    {

        $quantities = $request->input('quantity');
        $total_qtys = $request->input('total_qty');
        // dd($total_qtys['recorder'],$quantities['recorder'] );
        $products = $request->input('products');
        $standard_id = $request->input('selected_standard');
        $system_type_id = $request->input('selected_system_type');
        $first_selected_product_type = $request->input('first_selected_product_type');

        $quantity_arr = $errors = [];
        $product_arr = [];
        $total_products = 0;
        $quantity_filled = true;
        $attribute_selected = true;

        if($first_selected_product_type == 'camera'){
            $priority_product = 'recorder';
        }else if($first_selected_product_type == 'recorder'){
            $priority_product = 'camera';
        }
        $priority_product_series = '';
        if(!empty($priority_product)){
            $priority_product_type = Type::where('name', 'LIKE', $priority_product)->first();
            $get_priority_product = Product::whereHas('product_attributes.attribute', function ($q) use ($priority_product_type, $system_type_id) {
                $q->where('type_id', $priority_product_type->id)
                    ->where('system_type_id', $system_type_id);
            });

            $get_priority_product = $get_priority_product->where('system_type_id', $system_type_id)->where('type_id', $priority_product_type->id)->where('standard_id', $standard_id)->orderBy('priority', 'DESC')->orderBy('created_at', 'ASC')->first();

            $priority_product_attributes = ProductAttribute::with('attribute', 'attribute_value')->where('product_id', $get_priority_product->id)->whereHas('attribute', function ($q) {
                $q->where('name', 'LIKE', 'Series of Equipment');
                $q->orWhere('name', 'LIKE', 'Series of equipment');

            })->first();
            $priority_product_series = ($priority_product_attributes->attribute_value->value);
        }


        foreach ($products as $product_type => $product) {
            $quantity_total = 0;

            foreach ($product as $no => $attributes) {
                $unselected_attr_count = 0;
                $attribute_count = count($attributes);
                $type = Type::where('slug', 'LIKE', $product_type)->first();

                $model = Product::whereHas('product_attributes.attribute', function ($q) use ($type, $system_type_id, $priority_product_series) {
                    $q->where('type_id', $type->id)
                        ->where('system_type_id', $system_type_id);
                        if($priority_product_series){
                            $q->where('name', 'LIKE', 'Series of equipment');
                        }
                });

                if($priority_product_series){
                    $model->whereHas('product_attributes.attribute_value', function ($q) use ($type, $system_type_id, $standard_id, $priority_product_series) {
                        $q->where('type_id', $type->id)
                        ->where('standard_id', $standard_id)
                            ->where('system_type_id', $system_type_id);
                            if($priority_product_series){
                                $q->where('value', 'LIKE', $priority_product_series);
                            }
                    });
                  
                }

                foreach ($attributes as $key => $attribute) {
                    if ($attribute != NULL) {
                        $product_arr[$product_type][$no][$key] = $attribute;
                    }
                    if ($attribute != 'unimportant') {
                        $model->whereHas('product_attributes', function ($q) use ($attribute) {
                            $q->where('attribute_value_id', $attribute);
                        });
                    } else if ($attribute == 'unimportant') {
                        $unselected_attr_count++;
                    }
                }
                // dd($unselected_attr_count, $attribute_count);
                if ($unselected_attr_count == $attribute_count) {
                    $attribute_selected = false;
                } else {
                    $model = $model->select('name', 'price')->where('system_type_id', $system_type_id)->where('type_id', $type->id)->where('standard_id', $standard_id)->orderBy('priority', 'DESC')->orderBy('created_at', 'ASC')->first();
                    if ($model) {
                        $model = $model->toArray();
                        $product_arr[$product_type][$no]['model'] = $model;
                    }
                    if (!empty($quantities[$product_type][$no])) {
                        $quantity_arr[$product_type][$no]['qty'] = $quantities[$product_type][$no];
                        $quantity_arr[$product_type][$no]['total_qty'] = $total_qtys[$product_type][$no];
                        $quantity_total += (int)$total_qtys[$product_type][$no];
                    } else {
                        $quantity_filled = false;
                        break 2;
                    }
                }
            }
            $quantity_arr[$product_type]['total'] = $quantity_total;
            $total_products += $quantity_total;
        }

    
        if (!$quantity_filled) {
            return response()->json(['success' => false, 'message' => translate('Please Enter Quantity for the products.')]);
        }
        if (!$attribute_selected) {
            return response()->json(['success' => false, 'message' => translate('Please select at least one attribute for all product types.')]);
        }
        //dd($quantity_arr['recorder'][1]);
        //dd($errors);

        if ($total_products > 0) {
            $products = $product_arr;
            $quantities = $quantity_arr;
            $html = view('enquiries.partials.pdf', compact('products', 'quantities'))->render();
            return response()->json(['success' => true, 'html' => $html, 'priority_product_series' => $priority_product_series]);
        } else {
            return response()->json(['success' => false, 'message' => translate('Please Enter Quantity for the products.')]);
        }
    }
    // public function getStandard(Request $request){
    //     if($request->ajax() && $request->isMethod('post')){
    //         $system_type = $request->input('system_type_id');
    //         $standard_attribute='';
    //         $standards = Standard::where('system_type_id', $system_type)->get();
    //         $standard_attribute .= view('frontend.extras.standard', compact('standards'))->render();
    //         $html = [];
    //         $i = 1;
    //         $types = Type::get();
    //         foreach($types as $type) {
    //             $attributes = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type_id', $type->id)->orderBy('display_order', 'ASC')->get();
    //             $attribute_html = view('frontend.extras.filter', compact('attributes', 'system_type', 'i', 'type'))->render();
    //             $html[$type->slug] = view('frontend.extras.new-type', compact('attributes', 'system_type', 'i', 'type', 'attribute_html'))->render();
    //         }
    //         return response()->json(['success'=> true, 'standard_attribute' => $standard_attribute, 'html' => $html, 'count'=> $i]);

    //     }
    // }

    public function getStandard(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $system_type = $request->input('system_type_id');
            $standard_attribute = '';
            $standards = Standard::where('system_type_id', $system_type)->get();
            $standard_attribute .= view('frontend.extras.standard', compact('standards'))->render();
            // $html = [];
            $i = 1;
            $types = Type::get();
            // foreach($types as $type) {
            //     $attributes = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type_id', $type->id)->orderBy('display_order', 'ASC')->get();
            //     $attribute_html = view('frontend.extras.filter', compact('attributes', 'system_type', 'i', 'type'))->render();
            //     $html[$type->slug] = view('frontend.extras.new-type', compact('attributes', 'system_type', 'i', 'type', 'attribute_html'))->render();
            // }
            return response()->json(['success' => true, 'standard_attribute' => $standard_attribute,  'count' => $i]);
        }
    }

    public function getAttributes(Request $request)
    {

        if ($request->ajax() && $request->isMethod('post')) {
            $system_type = $request->input('system_type_id');
            $standard = $request->input('standard_id');
            // dd($standard);
            $html = [];
            $i = 1;
            $types = Type::get();
            foreach ($types as $type) {
                $attributes = Attribute::with('attribute_values')->where('system_type_id', $system_type)->where('type_id', $type->id)->orderBy('display_order', 'ASC')->get();
                $attribute_html = view('frontend.extras.filter', compact('attributes', 'system_type', 'i', 'type', 'standard'))->render();
                $html[$type->slug] = view('frontend.extras.new-type', compact('attributes', 'system_type', 'i', 'type', 'attribute_html'))->render();
            }

            return response()->json(['success' => true, 'html' => $html,  'count' => $i]);
        }
    }


    public function dd(Request $request)
    {
        // $quantities = $request->input('quantity');
        // $total_qtys = $request->input('total_qty');
        // dd($total_qtys['recorder'],$quantities['recorder'] );
        $products = [
            'recorder' => [
                1 => [
                    13 => "unimportant",
                    14 => "unimportant",
                    15 => "unimportant",
                    16 => "unimportant",
                    17 => "unimportant",
                    18 => "unimportant",
                    19 => "unimportant",
                    20 => "unimportant",
                    21 => "unimportant",
                    22 => "unimportant",
                    23 => "unimportant",
                    24 => "unimportant",
                    25 => "unimportant",
                    26 => "unimportant",
                ]
            ],
            'camera' => [
                1 => [
                    1 => "273",
                    2 => "unimportant",
                    3 => "unimportant",
                    4 => "unimportant",
                    5 => "unimportant",
                    6 => "unimportant",
                    7 => "unimportant",
                    8 => "276",
                    9 => "unimportant",
                    10 => "unimportant",
                    11 => "unimportant",
                    12 => "unimportant",
                ]
            ],

        ];


        //dd($products);

        $standard_id = '25';
        $system_type_id = '20';
        $quantity_arr = $errors = [];
        $product_arr = [];
        $total_products = 0;
        $quantity_filled = true;
        $attribute_selected = true;
        foreach ($products as $product_type => $product) {
            $quantity_total = 0;

            foreach ($product as $no => $attributes) {
                $unselected_attr_count = 0;
                $attribute_count = count($attributes);
                $type = Type::where('slug', 'LIKE', $product_type)->first();


                $model = Product::whereHas('product_attributes.attribute', function ($q) use ($type, $system_type_id) {
                    $q->where('type_id', $type->id)
                        ->where('system_type_id', $system_type_id);
                });

                foreach ($attributes as $key => $attribute) {
                    if ($attribute != NULL) {
                        $product_arr[$product_type][$no][$key] = $attribute;
                    }
                    if ($attribute != 'unimportant') {
                        $model->whereHas('product_attributes', function ($q) use ($attribute) {
                            $q->where('attribute_value_id', $attribute);
                        });
                    } else if ($attribute == 'unimportant') {
                        $unselected_attr_count++;
                    }
                }
                // dd($unselected_attr_count, $attribute_count);
                if ($unselected_attr_count == $attribute_count) {
                    $attribute_selected = false;
                    //return response()->json(['success' => false, 'message' => translate('Please select at least one attribute for all product types.')]); 
                    //$errors[$product_type] =  translate('Please select at least one attribute for all product types.');
                }
                // else{

                $model = $model->select('id', 'name', 'price', 'created_at')->where('system_type_id', $system_type_id)->where('type_id', $type->id)->where('standard_id', $standard_id)->orderBy('priority', 'DESC')->orderBy('created_at', 'ASC')->first();

                if ($model) {

                    $model = $model->toArray();
                    $product_arr[$product_type][$no]['model'] = $model;
                }

                // if (!empty($quantities[$product_type][$no])) {
                //     $quantity_arr[$product_type][$no]['qty'] = $quantities[$product_type][$no];
                //     $quantity_arr[$product_type][$no]['total_qty'] = $total_qtys[$product_type][$no];
                //     $quantity_total += (int)$total_qtys[$product_type][$no];
                // } else {
                //     $quantity_filled = false;
                //     break 2;
                // }
                //}

            }
            $quantity_arr[$product_type]['total'] = $quantity_total;
            $total_products += $quantity_total;
        }
        dd($product_arr);
    }
}
