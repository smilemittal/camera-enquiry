<?php

namespace App\Http\Controllers;

use Excel;
use App\Imports\SystemTypesImport;
use App\Exports\SystemTypesExport;
use Illuminate\Http\Request;
use App\Models\SystemType;
use Illuminate\Validation\Rule;

class SystemTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $system_types=SystemType::all();

        return view('system_types.index',compact('system_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system_types.create');
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
            'name'=>'required|max:50|'.Rule::unique('system_types')->whereNull('deleted_at'),
        ]);

        SystemType::create($request->all());

        return redirect()->route('system-types.index')->with('success',__('message.System type added successfully'));

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
        $system_types=SystemType::find($id);
        return view('system_types.edit',compact('system_types'));
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
            'name'=>'required|max:50|'.Rule::unique('system_types')->ignore($id)->whereNull('deleted_at'),
        ]);

        $system_types=SystemType::find($id);
        $system_types->update($request->all());

        return redirect()->route('system-types.index')->with('updated_success', __('message.System type updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $system_types=SystemType::find($id);
        $system_types->delete();

         return redirect()->route('system-types.index')->with('deleted_success', __('message.System type deleted successfully'));

    }
    public function multipleDelete(Request $request)
	{
        $id = $request->bulk_delete;

			SystemType::whereIn('id', $id)->delete();

		return redirect()->back();
	}

    public function getSystemTypes(Request $request) {
        $totalData = SystemType::count();
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
            $system_types = SystemType::orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $system_types =  SystemType::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $system_types->count();
        }
        $data = array();
        if (!empty($system_types)) {
            foreach ($system_types as $key => $system_type) {
                $nestedData['#']='<input type="checkbox" name="bulk_delete[]" class="checkboxes" value="'.$system_type->id.'" />';
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = $system_type->name;
                $index = route('system-types.index' ,  encrypt($system_type->id));
                $edit = route('system-types.update' ,  encrypt($system_type->id));
                $delete = route('system-types.destroy' ,  encrypt($system_type->id));
                $exist = $system_type;
                $comp = true;
                $nestedData['action'] = view('system_types.partials.setting-action',compact('index','exist','comp','edit','delete', 'system_type'))->render();
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

        public function importSystemTypes()
    {
        return view('imports.system-types');
    }

    public function postImport(Request $request)
    {

        if($request->hasFile('import-system-types')){

        $this->validate($request, [

            'import-system-types' => 'required|mimes:csv,xlsx,xls',

        ]);

        $import = new SystemTypesImport;

        Excel::import($import, request()->file('import-system-types'));

        if($import->imported_system_types > 0){
            return redirect()->route('system-types.import')->with('success', __('message.System types Imported successfully'));
        }else{
            if($import->existing_system_types > 0 && $import->existing_system_types == $import->total_system_types){
                return redirect()->route('system-types.import')->withErrors([__('message.System types Import Failed Exists')]);
            }else{
                return redirect()->route('system-types.import')->withErrors([__('message.System types Import Failed.')]);
            }
        }

    }

        
    }

    public function export()
    {
        return Excel::download(new SystemTypesExport ,'systemtypes.xlsx');
    }

}
