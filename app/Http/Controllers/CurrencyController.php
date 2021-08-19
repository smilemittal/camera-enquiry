<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('currency.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name'=>'required|max:50',
            'symbol'=>'required',
            'exchange_rate'=>'required',
            'status'=>'required',
            'code' => 'required',
        ]);
        $currency = Currency::create([
                        'name' => $request->input('name'),
                        'symbol' => $request->input('symbol'),
                        'exchange_rate' => $request->input('exchange_rate'),
                        'status' => $request->input('status'),
                        'code' => $request->input('code'),
                    ]);

        return redirect()->route('currency.index')->with('success', translate('Currency added successfully'));
    
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
    public function edit(Request $request, $id)
    {
        $currency = Currency::find($id);
        return view('currency.edit', compact('currency'));
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
            'symbol'=>'required',
            'exchange_rate'=>'required',
            'status'=>'required',
            'code' => 'required',
        ]);

        $currency = Currency::find($id);
        $currency->update([
            'name' => $request->input('name'),
            'symbol' => $request->input('symbol'),
            'exchange_rate' => $request->input('exchange_rate'),
            'status' => $request->input('status'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('currency.index')->with('success', translate('Currency updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency = Currency::find($id);

        $currency->delete();

        return redirect()->route('currency.index')->with('success', translate('Currency Deleted Successfully.'));
    }

    public function getCurrencies(Request $request) {

        $totalData = Currency::count();
        $totalFiltered = $totalData;
        $columns = array(
            0 => '#',
            1 =>'id',
            2 =>'name',
            3 =>'symbol',
            4 =>'code',
            5 =>'exchange_rate',
            6 => 'action',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $currencies = Currency::orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $currencies =  Currency::where('name','LIKE',"%{$search}%")
                ->orWhere('symbol', 'LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->orderBy($order, $dir)
                ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $currencies->count();
        }
        $data = array();
        if (!empty($currencies)) {
            foreach ($currencies as $key => $currency) {
                $nestedData['#']='<input type="checkbox" name="bulk_delete[]" class="checkboxes" value="'.$currency->id.'" />';
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['name'] = $currency->name;
                $nestedData['symbol'] = $currency->symbol;
                $nestedData['code'] = $currency->code;
                $nestedData['exchange_rate'] = $currency->exchange_rate;
                $index = route('currency.index' ,  ($currency->id));
                $edit = route('currency.edit' ,  ($currency->id));
                $destroy = route('currency.destroy' ,  ($currency->id));
                $exist = $currency;
                $comp = true;
                $nestedData['action'] = view('currency.partials.setting-action',compact('index','exist','comp','edit','destroy', 'currency'))->render();
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


    public function multipleDelete(Request $request)
	{
        $id = $request->bulk_delete;
        
        Currency::whereIn('id', $id)->delete();
	
		return redirect()->route('currency.index')->with('success', translate('Currencies Deleted Successfully.'));
	}


    public function set_default_currency(Request $request)
    {
      
        Currency::whereNotNull('id')->update(['is_default' => 0]);
        $currency = Currency::find($request->input('default_currency'));
        $currency->update(['is_default' => 1]);
        return back()->with('success',translate("Settings updated successfully"));
    }
}
