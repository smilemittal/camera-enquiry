<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Imports\ProductAttributesImport;
use App\Exports\ProductAttributesExport;

class ProductAttributesController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productattributes = ProductAttribute::with('product','attribute','attribute_value')->get();
         

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
        $request->validate([
            'product_id'=>'required',
            'attribute_id'=>'required',
            'attribute_value_id'=>'required'
        ]);

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
         $request->validate
         ([
            'product_id'=>'required',
            'attribute_id'=>'required',
            'attribute_value_id'=>'required'
        ]);

         $product_attributes = ProductAttribute::find($id);
         $product_attributes->update($request->all());
         
          return redirect()->route('product-attributes.index')->with('updated_success','ProductAttributes updated successfully');         

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

    return redirect()->route('product-attributes.index')->with('deleted_success','ProductAttributes deleted successfully');         

    }
    /**
     * Fetching, Sorting attribute values and Pagination.  
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function getProductAttribute(Request $request)
        {
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

            $productattributes = ProductAttribute::orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $productattributes =  ProductAttribute::with('attribute_value', 'attribute','product')->whereHas('attribute', function($q)use($search)
                { 
                    $q->where('name','LIKE',"%{$search}%");
                })->orWhereHas('attribute_value' , function($q)use($search)
                {
                    $q->where('value','LIKE',"%{$search}%");
                })->orWhereHas('product', function($q)use($search)
                {
                    $q->where('name','LIKE', "%{$search}%");
                })

                ->orWhere('product_id', 'LIKE',"%{$search}%")
                
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $productattributes->count();
        }
        
        $data = array();
        if (!empty($productattributes)) {
            foreach ($productattributes as $key => $productattribute) {
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['product_id'] = !empty($productattribute->product) ?$productattribute->product->name : '';
                $nestedData['attribute_id'] = !empty($productattribute->attribute) ?$productattribute->attribute->name : '';
                $nestedData['attribute_value_id'] = !empty($productattribute->attribute_value) ?$productattribute->attribute_value->value: '';
                $index = route('product-attributes.index' ,  encrypt($productattribute->id));
                $edit = route('product-attributes.edit' ,  encrypt($productattribute->id));
                $delete = route('product-attributes.destroy' ,  encrypt($productattribute->id));
                $exist = $productattribute;
                $comp = true;
                $nestedData['action'] = view('productattributes.partials.setting-action',compact('index','exist','comp','edit','delete', 'productattribute'))->render();
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

        public function importProductAttribute()
        {
           
            return view('imports.product-attributes');
        }

        public function postImport(Request $request)
        {

            if($request->hasFile('import-product-attributes')){
              
              
                Excel::import(new ProductAttributesImport, request()->file('import-product-attributes'));

        }
          
            return redirect()->route('product-attributes.import')->with('success', 'Products imported successfully');
        }

        public function export()
        {
            return Excel::download(new ProductAttributesExport , 'productattributes.xlsx');
        }

    }






