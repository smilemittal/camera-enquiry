<?php

namespace App\Http\Controllers;

use Excel;
use App\Imports\SystemTypesImport;
use App\Exports\SystemTypesExport;
use Illuminate\Http\Request;
use App\Models\SystemType;

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

        $request->validate([  
            'name'=>'required',  
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
     

        $request->validate([  
            'name'=>'required',
        ]);
  
        $system_types=SystemType::find($id);          
        $system_types->update($request->all()); 

        return redirect()->route('system-types.index')->with('success', __('message.System type updated successfully'));
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
        
         return redirect()->route('system-types.index')->with('success', __('message.System type deleted successfully'));

    }

    public function getSystemTypes(Request $request) {
        $totalData = SystemType::count();
        $totalFiltered = $totalData;
        $columns = array(
            0=>'id',
            1 =>'name',
            2 =>'action',
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
          
            Excel::import(new SystemTypesImport, request()->file('import-system-types'));

    }
      
        return redirect()->route('system-types.import')->with('success', __('message.SystemTypes Imported successfully'));
    }

    public function export()
    {
        return Excel::download(new SystemTypesExport ,'systemtypes.xlsx');
    }
    
}
