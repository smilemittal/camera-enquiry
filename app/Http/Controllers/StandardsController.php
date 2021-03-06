<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use App\Imports\StandardsImport;
use App\Exports\StandardsExport;
use App\Models\Standard;
use App\Models\SystemType;
use Illuminate\Validation\Rule;

class StandardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('standards.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $system_types = SystemType::all();
        return view('standards.create', compact('system_types'));
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
            'name'=>'required|max:50|'.Rule::unique('standards')->where('system_type_id', $request->input('system_type_id'))->whereNull('deleted_at'),
            'system_type_id'=>'required',
        ]);
        Standard::create($request->all());

        return redirect()->route('standards.index')->with('success',__('message.Standard added successfully'));

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
      $standard= Standard::find($id);
      $system_types = SystemType::all();
      return view('standards.edit',compact('standard','system_types'));


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
            'name'=>'required|max:50|'.Rule::unique('standards')->ignore($id)->where('system_type_id', $request->input('system_type_id'))->whereNull('deleted_at'),
            'system_type_id' => 'required',
        ]);

        $standard=Standard::find($id);

        $standard->update($request->all());

    return redirect()->route('standards.index')->with('updated',__('message.Standard updated successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $standard=Standard::find($id);
      $standard->delete();

      return redirect()->route('standards.index')->with('deleted',__('message.Standard deleted successfully'));

    }
    public function multipleDelete(Request $request)
	{
        $id = $request->bulk_delete;

        Standard::whereIn('id', $id)->delete();

		return redirect()->back();
	}

    public function getStandard(Request $request) {
        $totalData = Standard::count();
        $totalFiltered = $totalData;
        $columns = array(
            1=>'id',
            2 =>'name',
            3 =>'system_type',
            4 =>'action',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $standards = Standard::orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $standards =  Standard::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $standards->count();
        }
        $data = array();
        if (!empty($standards)) {
            foreach ($standards as $key => $standard) {
                $nestedData['#']='<input type="checkbox" name="bulk_delete[]" class="checkboxes" value="'.$standard->id.'" />';
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = $standard->name;
                $nestedData['system_type'] = $standard->system_type->name;
                $view = route('standards.index' ,  encrypt($standard->id));
                $edit = route('standards.edit' ,  encrypt($standard->id));
                $delete = route('standards.destroy' ,  encrypt($standard->id));
                $exist = $standard;
                $comp = true;
                $nestedData['action'] = view('standards.partials.setting-action',compact('view','exist','comp','edit','delete', 'standard'))->render();
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

     public function importStandards()
    {
        return view('imports.standards');
    }

    public function postImport(Request $request)
    {

        if($request->hasFile('import-standards')){

               $this->validate($request, [
                'import-standards'=>'required|mimes:csv,xlsx,xls',
                ]);

                $import = new StandardsImport;
                Excel::import($import, request()->file('import-standards'));

                if($import->imported_standards > 0){
                    return redirect()->route('standards.import')->with('success', __('message.Standards Imported successfully'));
                }else{
                    if($import->existing_standards > 0 && $import->existing_standards == $import->total_standards){
                        return redirect()->route('standards.import')->withErrors([__('message.Standards Import Failed Exists.')]);
                    }else{
                        return redirect()->route('standards.import')->withErrors([__('message.Standards Import Failed.')]);
                    }
                   
                }
            

        }

       
    }

    public function export()
    {
        return Excel::download(new StandardsExport , "standards.xlsx");
    }
}
