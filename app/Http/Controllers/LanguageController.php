<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Validation\Rule;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::all();

        return view('language.index',compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('language.create');
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
            'name'=>'required|max:50|'.Rule::unique('languages')->whereNull('deleted_at'),
        ]);

        Language::create($request->all());

        return redirect()->route('languages.index')->with('success',__('message.Language added successfully'));

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
        $languages=Language::find($id);
        return view('language.edit',compact('languages'));
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
            'name'=>'required|max:50|'.Rule::unique('languages')->ignore($id)->whereNull('deleted_at'),
        ]);

        $languages=Language::find($id);
        $languages->update($request->all());

        return redirect()->route('languages.index')->with('updated_success', __('message.Language updated successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $languages=Language::find($id);
        $languages->delete();

         return redirect()->route('languages.index')->with('deleted_success', __('message.Language deleted successfully'));


    }
    public function multipleDelete(Request $request)
	{
        $id = $request->bulk_delete;

        Language::whereIn('id', $id)->delete();

		return redirect()->back();
	}
    public function getLanguages(Request $request) {
        $totalData = Language::count();
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
            $languages = Language::orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $languages =  Language::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $languages->count();
        }
        $data = array();
        if (!empty($languages)) {
            foreach ($languages as $key => $language) {
                $nestedData['#']='<input language="checkbox" name="bulk_delete[]" class="checkboxes" value="'.$language->id.'" />';
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = $language->name;
                $index = route('languages.index' ,  encrypt($language->id));
                $edit = route('languages.update' ,  encrypt($language->id));
                $delete = route('languages.destroy' ,  encrypt($language->id));
                $exist = $language;
                $comp = true;
                $nestedData['action'] = view('language.partials.setting-action',compact('index','exist','comp','edit','delete', 'language'))->render();
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
