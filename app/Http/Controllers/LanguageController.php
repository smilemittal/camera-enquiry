<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Translation;
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

        return view('language.index', compact('languages'));
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
            'name' => 'required|max:50|' . Rule::unique('languages')->whereNull('deleted_at'),
        ]);

        Language::create($request->all());

        return redirect()->route('languages.index')->with('success', translate('Language added successfully'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $language = Language::findOrFail(decrypt($id));
        return view('language.language_view', compact('language'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $languages = Language::find($id);
        return view('language.edit', compact('languages'));
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
            'name' => 'required|max:50|' . Rule::unique('languages')->ignore($id)->whereNull('deleted_at'),
        ]);

        $languages = Language::find($id);
        $languages->update($request->all());

        return redirect()->route('languages.index')->with('updated_success', translate('Language updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $languages = Language::find($id);
        $languages->delete();

        return redirect()->route('languages.index')->with('deleted_success', translate('Language deleted successfully'));
    }

    /**
     * Translation Multidelete Function
    */
    public function multipleDelete(Request $request)
    {
        $id = $request->bulk_delete;

        Translation::whereIn('id', $id)->delete();

        return redirect()->back();
    }

    /**
     * Languages ajax pagination function
    */
    public function getLanguages(Request $request)
    {
        $totalData = 0;
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'code',
            3 => 'rtl',
            4 => 'action',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $languages = Language::orderBy($order, $dir);
        $totalData = $languages->count();

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $languages = $languages->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%");
        }
        $languages = $languages->paginate($limit, ['*'], 'page', $start + 1);
        $totalFiltered = $languages->total();
        $data = array();
        if (!empty($languages)) {
            foreach ($languages as $key => $language) {
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = $language->name;
                $nestedData['code'] = $language->code;
                if ($language->rtl == 1) {
                    $nestedData['rtl'] = '<input type="hidden" name="language_status[]" value="'.$language->id.'"><input name="status['.$language->id.']" value="1" type="checkbox" checked />';
                } else {
                    $nestedData['rtl'] = '<input type="hidden" name="language_status[]" value="'.$language->id.'"><input name="status['.$language->id.']" value="0" type="checkbox" />';
                }
                $index = route('languages.index', encrypt($language->id));
                $edit = route('languages.update', encrypt($language->id));
                $delete = route('languages.destroy', encrypt($language->id));
                $show = route('languages.show', encrypt($language->id));
                $exist = $language;
                $comp = true;
                $nestedData['action'] = view('language.partials.setting-action', compact('index', 'exist', 'comp', 'edit', 'delete', 'show', 'language'))->render();
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return json_encode($json_data);
    }
    /**
     * Translation update function
    */
    public function key_value_store(Request $request)
    {
        $language = Language::findOrFail($request->id);
        if ($request->has('update')) {

            foreach ($request->values as $key => $value) {
                $translation_def = Translation::where('lang_key', $key)->where('lang', $language->code)->first();
                if ($translation_def == null) {
                    $translation_def = new Translation;
                    $translation_def->lang = $language->code;
                    $translation_def->lang_key = $key;
                    $translation_def->lang_value = $value;
                    $translation_def->save();
                } else {
                    $translation_def->lang_value = $value;
                    $translation_def->save();
                }
            }
        } else {
            $translations = $request->bulk_delete;
            Translation::whereIn('id', $translations)->delete();
        }

        //forgetCachedTranslations();
        // //saveJSONFile($language->code, $data);
        return back()->with('success', 'Translations updated for ' .$language->name);
    }
    /**
     * Single Translation delete dunction
    */
    public function destroytrans($id)
    {
        $language_translation = Translation::find($id);
        $language_translation->delete();

        return redirect()->back()->with('deleted_success', translate('Translation deleted successfully'));
    }

    /**
     * Update RTL status function
    */
    public function update_rtl_status(Request $request)
    {
        foreach($request->language_status as $lang_id){
            $language = Language::findOrFail($lang_id);
            if (!empty($request->status) && array_key_exists($lang_id, $request->status)){
                $language->rtl = 1;
            }else{
                $language->rtl = 0;
            }
            $language->save();
        }
        return back()->with('success', translate('RTL status updated successfully'));

    }

    /**
     * Translation ajax pagination function
    */
    public function getLanguagesTranslations(Request $request, $lang)
    {
        $totalData = 0;
        $columns = array(
            0 => '#',
            1 => 'id',
            2 => 'lang_key',
            3 => 'lang_value',
            4 => 'action'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $translations = Translation::where('lang', $lang)->orderBy($order, $dir);
        $totalData = $translations->count();

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $translations = $translations->where('id', 'LIKE', "%{$search}%")
                ->orWhere('lang_key', 'LIKE', "%{$search}%");
        }
        $translations = $translations->paginate($limit, ['*'], 'page', $start + 1);
        $totalFiltered = $translations->total();
        $data = array();
        if (!empty($translations)) {
            foreach ($translations as $key => $language_translation) {
                $nestedData['#'] = '<input type="checkbox" name="bulk_delete[]" class="checkboxes" value="' . $language_translation->id . '" />';
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['lang_key'] = $language_translation->lang_key;
                $nestedData['lang_value'] = '<input type="text" class="form-control"  name="values[' . $language_translation->lang_key . ']" value="' . $language_translation->lang_value . '" />';
                $delete = route('languages_trans.destroy', encrypt($language_translation->id));
                $exist = $language_translation;
                $comp = true;
                $nestedData['action'] = view('language.partials.translation-action', compact('exist', 'delete', 'language_translation'))->render();
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return json_encode($json_data);
    }
}
