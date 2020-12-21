<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\Attribute;
use App\Models\SystemType;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Imports\AttributeValuesImport;
use App\Exports\AttributeValuesExport;


class AttributeValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attribute_values=AttributeValue::with('system_type', 'attribute')->get();
        
        return view('attribute_values.index',compact('attribute_values'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes=Attribute::all();
        $system_types=SystemType::all();

        return view('attribute_values.create',compact('attributes','system_types'));
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
            'attribute_id'=>'required',
            'value'=>'required|max:50|unique:attribute_values,value',
            'display_order'=>'required|max:50|unique:attribute_values,display_order',
            'system_type_id'=>'required',
        ]);

        AttributeValue::create($request->all());

        return redirect()->route('attribute-values.index')->with('success', __('message.Attribute value added successfully'));
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
        $attribute_value=AttributeValue::find($id);
        $attributes=Attribute::all();
        $system_types=SystemType::all();

        return view('attribute_values.edit',compact('attributes','attribute_value','system_types'));
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
         $request->validate([  
            'attribute_id'=>'required',
            'value'=>'required',
            'display_order'=>'required',
            'system_type_id'=>'required',
        ]);
  
        $attribute_values=AttributeValue::find($id);          
        $attribute_values->update($request->all()); 

        return redirect()->route('attribute-values.index')->with('updated', __('message.Attribute value updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute_values=AttributeValue::find($id);  
        $attribute_values->delete();
        
        return redirect()->route('attribute-values.index')->with('delete', __('message.Attribute value deleted successfully'));
    }

    /**
     * Fetching, Sorting attribute values and Pagination.  
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAttributeValues(Request $request) 
    {
        $totalData = AttributeValue::count();
        $totalFiltered = $totalData;
        $columns = array(
            0=>'id',
            1 =>'attribute_id',
            2 =>'value',
            3 =>'display_order',
            4 =>'system_type_id',
            5 =>'action'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $attribute_values = AttributeValue::with('system_type', 'attribute')->orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $attribute_values =  AttributeValue::with('system_type', 'attribute')->whereHas('system_type', function($q)use($search)
                {
                    $q->where('name','LIKE',"%{$search}%");
                })->orWhereHas('attribute', function($q)use($search)
                {
                    $q->where('name','LIKE',"%{$search}%");
                })   
                ->orWhere('attribute_id', 'LIKE',"%{$search}%")
                ->orWhere('value', 'LIKE',"%{$search}%")
                ->orWhere('display_order', 'LIKE',"%{$search}%")
                ->orWhere('system_type_id', 'LIKE',"%{$search}%")
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $attribute_values->count();
        }
        $data = array();
        if (!empty($attribute_values)) {
            foreach ($attribute_values as $key => $attribute_value) {

                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['attribute_id'] = !empty($attribute_value->attribute) ?$attribute_value->attribute->name : '';
                $nestedData['value'] = $attribute_value->value;
                $nestedData['display_order'] = $attribute_value->display_order;
                $nestedData['system_type_id'] = !empty($attribute_value->system_type) ? $attribute_value->system_type->name : '';
                $index = route('attribute-values.index' ,  encrypt($attribute_value->id));
                $edit = route('attribute-values.update' ,  encrypt($attribute_value->id));
                $delete = route('attribute-values.destroy' ,  encrypt($attribute_value->id));
                $exist = $attribute_value;
                $comp = true;
                $nestedData['action'] = view('attribute_values.partials.setting-action',compact('index','exist','comp','edit','delete', 'attribute_value'))->render();
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
