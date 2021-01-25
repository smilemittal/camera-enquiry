<?php

namespace App\Http\Controllers;
use Excel;
use App\Imports\TypesImport;
use App\Exports\TypesExport;
use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Validation\Rule;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types=Type::all();

        return view('type.index',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('type.create');
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
            'name'=>'required|max:50|'.Rule::unique('types')->whereNull('deleted_at'),
        ]);

        Type::create($request->all());

        return redirect()->route('types.index')->with('success',__('message.Type added successfully'));

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
        $types=Type::find($id);
        return view('type.edit',compact('types'));
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
            'name'=>'required|max:50|'.Rule::unique('types')->ignore($id)->whereNull('deleted_at'),
        ]);

        $types=Type::find($id);
        $types->update($request->all());

        return redirect()->route('types.index')->with('updated_success', __('message.Type updated successfully'));
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $types=Type::find($id);
        $types->delete();

         return redirect()->route('types.index')->with('deleted_success', __('message.Type deleted successfully'));

   
    }
    public function multipleDelete(Request $request)
	{
        $id = $request->bulk_delete;
        
        Type::whereIn('id', $id)->delete();
	
		return redirect()->back();
	}
    public function getTypes(Request $request) {
        $totalData = Type::count();
        $totalFiltered = $totalData;
        $columns = array(
            1=>'id',
            2 =>'name',
            3 =>'action',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $types = Type::orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $types =  Type::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $types->count();
        }
        $data = array();
        if (!empty($types)) {
            foreach ($types as $key => $type) {
                $nestedData['#']='<input type="checkbox" name="bulk_delete[]" class="checkboxes" value="'.$type->id.'" />';
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = $type->name;
                $index = route('types.index' ,  encrypt($type->id));
                $edit = route('types.update' ,  encrypt($type->id));
                $delete = route('types.destroy' ,  encrypt($type->id));
                $exist = $type;
                $comp = true;
                $nestedData['action'] = view('type.partials.setting-action',compact('index','exist','comp','edit','delete', 'type'))->render();
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
    public function importTypes()
    {
        return view('imports.types');
    }

    public function postImport(Request $request)
    {

        if($request->hasFile('import-types')){

        $this->validate($request, [

            'import-types' => 'required|mimes:csv,xlsx,xls',

        ]);
        Excel::import(new TypesImport, request()->file('import-types'));

    }

        return redirect()->route('types.import')->with('success', __('message.Types Imported successfully'));
    }

    public function export()
    {
        return Excel::download(new TypesExport ,'types.xlsx');
    }

}
