<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use App\Imports\StandardsImport;
use App\Exports\StandardsExport;
use App\Models\Standard;

class StandardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $standard = Standard::all();
        return view('standards.index',compact('standard'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    return view('standards.create');
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
            'name'=>'required|max:50|unique:standards,name,deleted_at,NULL',
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
      return view('standards.edit',compact('standard'));


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
            'name'=>'required|max:50|unique:standards,name,'.$id.',id,deleted_at,NULL',
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

    public function getStandard(Request $request) {
        $totalData = Standard::count();
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
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = $standard->name;
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
            Excel::import(new StandardsImport, request()->file('import-standards'));

    }

        return redirect()->route('standards.import')->with('success', __('message.Standards Imported successfully'));
    }

    public function export()
    {
        return Excel::download(new StandardsExport , "standards.xlsx");
    }
}
