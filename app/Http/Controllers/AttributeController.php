<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use App\Models\SystemType;
use App\Models\Attribute;
use App\Exports\AttributeExport;


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
        return view('attribute.create', compact('system_types'));
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
            'type'=>'required',
            'display_order'=>'required',
            'system_type_id'=>'required',
            'description' =>'required'
            
        ]);
        Attribute::create($request->all());
            // 
        return redirect()->route('attribute.create')->with('success', __('message.Attribute added successfully'));
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
        return view('attribute.edit', compact('attribute','system_types'));
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
            'type'=>'required',
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
    public function getattribute(Request $request) 
    {

        $totalData = Attribute::count();
        $totalFiltered = $totalData;
        $columns = array(
            0=>'id',
            1 =>'name',
            2 =>'type',
            3 =>'display_order',
            4 =>'system_type_id',
            5 =>'description',
            6 =>'action',
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
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = ucfirst($attribute->name);
                $nestedData['type'] =ucfirst($attribute->type);
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
            
            $this->validate($request, [
          
                'import-attribute-values' => 'required|mimes:csv,xlsx,xls',
                
            ]);
            Excel::import(new AttributeValuesImport, request()->file('import-attribute-values'));

        }
      
        return redirect()->route('attribute-values.import')->with('success',__('Message.Attributes Imported successfully'));
    }
    
    public function export() 
    {
        return Excel::download(new AttributeExport, 'AttributeData.xlsx');
    }
      

}
