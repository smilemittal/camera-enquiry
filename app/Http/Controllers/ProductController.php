<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Standard;
use App\Models\Attribute;
use App\Models\SystemType;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
        $products=Product::all();
        return view('products.index',compact('products'));
        }catch (Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $system_types = SystemType::all();
        $types = Type::all();
        $standards = Standard::all();
        return view('products.create', compact('system_types', 'standards','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name'=>'required|max:50',
            'type_id'=>'required',
            'system_type_id'=>'required',
            'priority'=>'required',
            'standard_id'=>'required',
        ]);
        $product = Product::create([
                        'name' => $request->input('name'),
                        'type_id' => $request->input('type_id'),
                        'system_type_id' => $request->input('system_type_id'),
                        'priority' => $request->input('priority'),
                        'standard_id' => $request->input('standard_id'),
                    ]);

        if(!empty($request->input('attribute_value'))){
            foreach($request->attribute_value as $attribute_id => $attribute_value_id){
                if(!empty($attribute_value_id)){
                    ProductAttribute::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute_id,
                        'attribute_value_id' => $attribute_value_id,
                    ]);
                }
            }
        }
        return redirect()->route('products.index')->with('success', __('message.Product added successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::with('product_attributes.attribute', 'product_attributes.attribute_value')->find($id);
        $attribute_value_ids = $attribute_ids = [];
        foreach($product->product_attributes as $product_attribute){
            $attribute_value_ids[] = $product_attribute->attribute_value_id;
            $attribute_ids[] = $product_attribute->attribute_id;
        }
        $standards = Standard::where('system_type_id', $product->system_type_id)->get();
        $attributes= Attribute::with('attribute_values')->where('created_at', '!=', Null)->where('type_id', $product->type_id)->where('system_type_id', $product->system_type_id)->get();
        $system_types = SystemType::all();
        $types = Type::all();
        
        return view('products.edit', compact('product', 'system_types','types', 'attribute_ids', 'attribute_value_ids', 'attributes', 'standards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|max:50|'.Rule::unique('products')->ignore($id)->whereNull('deleted_at'),
            'type_id' => 'required',
            'system_type_id' => 'required',
            'priority'=>'required',
            'standard_id' => 'required',
        ]);


        $product=Product::find($id);
        $product->update([
            'name' => $request->input('name'),
            'type_id' => $request->input('type_id'),
            'system_type_id' => $request->input('system_type_id'),
            'priority' => $request->input('priority'),
            'standard_id' => $request->input('standard_id'),
        ]);
        if(!empty($request->input('attribute_value'))){
            foreach($request->attribute_value as $attribute_id => $attribute_value_id){
                if(!empty($attribute_value_id)){
                    $product_attribute = ProductAttribute::where('product_id', $product->id)->where('attribute_id', $attribute_id)->first();
                    if(!empty($product_attribute)){
                        $product_attribute->update([
                            'product_id' => $product->id,
                            'attribute_id' => $attribute_id,
                            'attribute_value_id' => $attribute_value_id,
                        ]);
                    }else{
                        ProductAttribute::updateOrCreate([
                            'product_id' => $product->id,
                            'attribute_id' => $attribute_id,
                            'attribute_value_id' => $attribute_value_id,
                        ]);
                    }

                }

            }
        }
       return redirect()->route('products.index')->with('updated',__('message.Product updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletes=Product::find($id);
        $deletes->delete();
        return redirect()->route('products.index')->with('deleted',__('message.Product deleted successfully'));
    }
    public function multipleDelete(Request $request)
	{
        $id = $request->bulk_delete;
        
        Product::whereIn('id', $id)->delete();
	
		return redirect()->back();
	}
    public function getproduct(Request $request) {

        $totalData = Product::count();
        $totalFiltered = $totalData;
        $columns = array(
            0=>'id',
            1 =>'name',
            2 =>'priority',
            3 =>'action',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $products = Product::orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $products =  Product::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $products->count();
        }
        $data = array();
        if (!empty($products)) {
            foreach ($products as $key => $product) {
                $nestedData['#']='<input type="checkbox" name="bulk_delete[]" class="checkboxes" value="'.$product->id.'" />';
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = $product->name;
                $nestedData['priority'] = $product->priority;
                $index = route('products.index' ,  ($product->id));
                $edit = route('products.edit' ,  ($product->id));
                $destroy = route('products.destroy' ,  ($product->id));
                $exist = $product;
                $comp = true;
                $nestedData['action'] = view('products.partials.setting-action',compact('index','exist','comp','edit','destroy', 'product'))->render();
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"=> intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function getProductAttributes(Request $request){
        if($request->ajax()){
            $type = $request->type_id;
            $system_type = $request->system_type_id;

            $attribute= Attribute::with('attribute_values')->where('created_at', '!=', Null);

            if(!empty($type)){

                $attribute->where('type_id','=' ,$type);
            }

            if(!empty($system_type)){
                $attribute->where('system_type_id','=', $system_type);
            }

            $attributes = $attribute->get();

            $html = '';
            $html .= view('products.partials.select-attributes', compact('attributes'))->render();

            return response()->json(['html' => $html, 'success' => true]);
        }
    }
    public function getStandard(Request $request){
        if($request->ajax()){
            $system_type = $request->system_type_id;
            

            $standards= Standard:: where('created_at', '!=', Null)->where('system_type_id','=', $system_type)->get();


            $html = '';
            $html .= view('products.partials.standard-attribute', compact('standards'))->render();

            return response()->json(['html' => $html, 'success' => true]);
        }
    }
}
