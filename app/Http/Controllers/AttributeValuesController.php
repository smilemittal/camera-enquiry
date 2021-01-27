<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Attribute;
use App\Models\SystemType;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\AttributeValue;


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
        $types=Type::all();

        return view('attribute_values.create',compact('attributes','system_types','types'));
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
            'value'=>'required|max:50|'.Rule::unique('attribute_values')->whereNull('deleted_at'),
            'display_order'=>'required',
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
        $types=Type::all();

        return view('attribute_values.edit',compact('attributes','attribute_value','system_types','types'));
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
            'value'=>'required|max:50|',
            'display_order'=>'required',
            'system_type_id'=>'required',
        ]);

        $attribute_values=AttributeValue::find($id);
        $attribute_values->update($request->all());

        return redirect()->route('attribute-values.index')->with('updated_success', __('message.Attribute value updated successfully'));
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

        return redirect()->route('attribute-values.index')->with('delete_success', __('message.Attribute value deleted successfully'));
    }
    public function multipleDelete(Request $request)
	{
        $id = $request->bulk_delete;
        
        AttributeValue::whereIn('id', $id)->delete();
	
		return redirect()->back();
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
            1=>'id',
            2 =>'attribute_id',
            3 =>'value',
            4 =>'display_order',
            5 =>'system_type_id',
            6 =>'action'
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
                $nestedData['#']='<input type="checkbox" name="bulk_delete[]" class="checkboxes" value="'.$attribute_value->id.'" />';
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

    public function getAttributes(Request $request){
        if($request->ajax()){
            $type = $request->type;
            $system_type = $request->system_type_id;

            $attribute= Attribute::with('attribute_values')->where('created_at', '!=', Null);

            if(!empty($type)){

                $attribute->where('type','=' ,$type);
            }

            if(!empty($system_type)){
                $attribute->where('system_type_id','=', $system_type);
            }

            $attributes = $attribute ->orderBy('display_order', 'ASC')->get();

            $html = '';
            $html .= view('attribute_values.partials.select-attribute', compact('attributes'))->render();

            return response()->json(['html' => $html, 'success' => true]);
        }
    }


}
