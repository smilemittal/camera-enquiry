<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use App\Models\SystemType;
use App\Models\Attribute;
use App\Models\Type;
use App\Exports\AttributeExport;
use App\Imports\AttributeValuesImport;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $attributes=Attribute::with('system_type')->get();
            return view('attribute.index',compact('attributes'));
            }
            catch (Exception $e)
            {
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
        return view('attribute.create', compact('system_types','types'));
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
            'display_order'=>'required',
            'system_type_id'=>'required',
            'description' =>'required'

        ]);
        Attribute::create($request->all());
            //
        return redirect()->route('attribute.index')->with('success', __('message.Attribute added successfully'));
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
        $attribute=Attribute::find($id);
        $system_types = SystemType::all();
        $types = Type::all();
        return view('attribute.edit', compact('attribute','system_types','types'));
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
            'name'=>'required|max:50',
            'type_id'=>'required',
            'display_order'=>'required',
            'system_type_id'=>'required',
            'description' =>'required'
            ]);

        $attribute=Attribute::find($id);
        $attribute->update($request->all());
       return redirect()->route('attribute.index')->with('updated',__('message.Attribute updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletes=Attribute::find($id);
        $deletes->delete();
        return redirect()->route('attribute.index')->with('deleted', __('message.Attribute deleted successfully'));
    }
    public function multipleDelete(Request $request)
	{
        $id = $request->bulk_delete;

        Attribute::whereIn('id', $id)->delete();

		return redirect()->back();
	}
    public function getattribute(Request $request)
    {

        $totalData = Attribute::count();
        $totalFiltered = $totalData;
        $columns = array(
            1=>'id',
            2 =>'name',
            3 =>'type_id',
            4 =>'display_order',
            5 =>'system_type_id',
            6 =>'description',
            7 =>'action',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $attributes = Attribute::orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $attributes =  Attribute::whereHas('system_type', function($q)use($search)
            {
                $q->where('name','LIKE',"%{$search}%");
            })
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $attributes->count();
        }
        $data = array();
        if (!empty($attributes)) {
            foreach ($attributes as $key => $attribute) {
                $nestedData['#']='<input type="checkbox" name="bulk_delete[]" class="checkboxes" value="'.$attribute->id.'" />';
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = ucfirst($attribute->name);
                $nestedData['type_id'] =!empty($attribute->type) ? $attribute->type->name : '';
                $nestedData['display_order'] = $attribute->display_order;
                $nestedData['system_type_id'] = !empty($attribute->system_type) ? $attribute->system_type->name : '';
                $nestedData['description'] = $attribute->description;

                $index = route('attribute.index' ,  ($attribute->id));
                $edit = route('attribute.edit' ,  ($attribute->id));
                $destroy = route('attribute.destroy' ,  ($attribute->id));
                $exist = $attribute;
                $comp = true;
                $nestedData['action'] = view('attribute.partials.setting-action',compact('index','exist','comp','edit','destroy', 'attribute'))->render();
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
    public function importAttributeValues()
    {
        return view('imports.attribute-values');
    }

    public function postImport(Request $request)
    {
        $this->validate($request, [

            'import-attribute-values' => 'required|mimes:csv,xlsx,xls',

        ]);
        if($request->hasFile('import-attribute-values')){
            Excel::import(new AttributeValuesImport, request()->file('import-attribute-values'));
        }

        return redirect()->back()->with('success',__('Message.Attributes Imported successfully'));
    }

    public function export()
    {
        return Excel::download(new AttributeExport, 'AttributeData.xlsx');
    }


}
