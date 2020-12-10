<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use App\Models\AttributeValue;




class ProductAttributesController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productattributes = ProductAttribute::all();
         

         return view('productattributes.index', compact('productattributes'));         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $attributes = Attribute::all();
        $attributevalues =AttributeValue::all();
         return view('productattributes.create', compact('products', 'attributes','attributevalues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $request->validate(['product_id'=>'required',
                      'attribute_id'=>'required',
                'attribute_value_id'=>'required']);

        ProductAttribute::create($request->all());

        return redirect()->route('product-attributes.index')->with('success','ProductAttributes added successfully');         
    

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
        $product_attributes= ProductAttribute::find($id);
        $products = Product::all();
        $attributes = Attribute::all();
        $attributevalues =AttributeValue::all();
         return view('productattributes.edit', compact('id','product_attributes','products', 'attributes','attributevalues'));

       
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
         $request->validate(['product_id'=>'required',
                      'attribute_id'=>'required',
                'attribute_value_id'=>'required']);

         $product_attributes = ProductAttribute::find($id);
         $product_attributes->update($request->all());
         
          return redirect()->route('product-attributes.index')->with('success','ProductAttributes updated successfully');         

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    $product_attributes = ProductAttribute::find($id);
    $product_attributes->delete();
    return redirect()->route('product-attributes.index')->with('success','ProductAttributes deleted successfully');         

    }
    
        public function getProductAttribute(Request $request) {
        $totalData = ProductAttribute::count();
        $totalFiltered = $totalData;
        $columns = array(
            0 =>'id',
            1 =>'product_id',
            2 =>'attribute_id',
            3 =>'attribute_value_id',
            4 =>'action',
           
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $productatrributes = ProductAttribute::orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $productatrributes =  ProductAttribute::where('id','LIKE',"%{$search}%")
                ->orWhere('product_id', 'LIKE',"%{$search}%")
                ->orWhere('attribute_id', 'LIKE',"%{$search}%")
                ->orWhere('attribute_value_id', 'LIKE',"%{$search}%")
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $productatrributes->count();
        }
        $data = array();
        if (!empty($productatrributes)) {
            foreach ($productatrributes as $key => $productatrribute) {
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['product_id']=($productatrribute->id);
                $nestedData['attribute_id']=($productatrribute->id);
                $nestedData['attribute_value_id']=($productatrribute->id);




/*
                $nestedData['product_id'] = !empty($productatrribute->product) ?$productatrribute->product->name:'';
                $nestedData['attribute_id'] = !empty($productatrribute->attribute) ?$productatrribute->attribute->name:'';
                $nestedData['attribute_value_id'] = !empty($productatrribute->attribute_value) ?$productatrribute->attributevalue->id:'';*/

                $index = route('product-attributes.index' ,  encrypt($productatrribute->id));
                $edit = route('product-attributes.edit' ,  encrypt($productatrribute->id));
                $delete = route('product-attributes.destroy' ,  encrypt($productatrribute->id));
                $exist = $productatrribute;
                $comp = true;
                $nestedData['action'] = view('productattributes.partials.setting-action',compact('index','exist','comp','edit','delete', 'productatrribute'))->render();
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
}




