<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnquiryController extends Controller
{
    public function index(){
        return view('enquiries.index');
    }


    public function getEnquiries(Request $request){

        $enquiry_arr = [];
        $totalData = Enquiry::count();
        $totalFiltered = $totalData;
        $columns = array(
            0=>'id',
            1 =>'name',
            2 =>'type',
            3 =>'display_order',
            4 =>'system_type_id',
            5 =>'action',
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $start = $start ? $start / $limit : 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {
            $enquiries = Enquiry::with('system_type', 'standard')->orderBy($order, $dir)
            ->paginate($limit, ['*'], 'page', $start + 1);
            $totalFiltered = $totalData;
        }else {
            $search = $request->input('search.value');
            $enquiries =  Enquiry::with('system_type', 'standard')
            ->whereHas('system_type', function($q)use($search){
                $q->where('name','LIKE',"%{$search}%");
            })
            ->orWhereHas('standard', function($q)use($search){
                $q->where('name','LIKE',"%{$search}%");
            })
            ->orWhere(DB::raw('concat(first_name," ",last_name)'), 'like', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('company', 'LIKE', "%{$search}%")
            ->orWhere('mobile_no', 'LIKE', "%{$search}%")
            ->orderBy($order, $dir)                
            ->paginate($limit, ['*'], 'page', $start + 1);

            $totalFiltered = $enquiries->count();
        }
        $data = array();
        if (!empty($enquiries)) {
            foreach ($enquiries as $key => $enquiry) {
                $product_name = '';
                $quantity_total = 0;
                $products = json_decode($enquiry->products, true);
                $quantities  = json_decode($enquiry->quantity, true);
        
                foreach($products as $product_type => $product){
                  
                    foreach($product as $no => $attributes){
                        
                            if(!empty($quantities[$product_type][$no])){
                                //dd($quantities[$product_type][$no]);
                                        $quantity_total += (int)$quantities[$product_type][$no];
                            }
                           
                    }
                    $product_name .= 'Product Type: '.ucfirst($product_type).', Qty: '.$quantity_total."<br>";
                }
             
                    $first_name =  !empty( $enquiry->first_name)? $enquiry->first_name:'';
                    $last_name = !empty( $enquiry->last_name)? $enquiry->last_name: '';
                
                $nestedData['id'] = ($start * $limit) + $key + 1;
                $nestedData['customer_name'] = $first_name.' '.$last_name;
                $nestedData['last_name'] = $enquiry->last_name;
                $nestedData['email'] = $enquiry->email;
                $nestedData['mobile_no'] = $enquiry->mobile_no;
                // $nestedData['company'] = $enquiry->company;
                // $nestedData['name'] = $product_name;
                // $nestedData['system_type_id'] = !empty($enquiry->system_type) ? $enquiry->system_type->name : '';
                // $nestedData['standard_id'] = !empty($enquiry->standard) ? $enquiry->standard->name : '';
                $nestedData['date'] = \Carbon\Carbon::parse($enquiry->created_at)->diffForHumans();
                

                $index = route('enquiries.show' ,  ($enquiry->id));
               
                $destroy = route('enquiries.destroy' ,  ($enquiry->id));
                $exist = $enquiry;
                $comp = true;
                $nestedData['action'] = view('enquiries.partials.setting-action',compact('index','exist','comp','destroy', 'enquiry'))->render();
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


    public function show($id){
        $enquiry = Enquiry::where('id', $id)->first();
        return view('enquiries.show', compact('enquiry'));
    }

    public function destroy($id){
       
        $enquiry = Enquiry::find($id);
        $enquiry->delete();
        return redirect()->route('enquiries.index')->with('success', __('message.Enquiry deleted successfully'));         
    }
}
