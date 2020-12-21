@extends('layouts.app')

@section('content')

    <!-- BEGIN: Content-->

            
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"></h4>

                                    <a class="heading-elements-toggle">
                                        <i class="la la-ellipsis-v font-medium-3"></i>
                                    </a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a data-action="collapse">
                                                    <i class="ft-minus"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="reload">
                                                    <i class="ft-rotate-cw"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="expand">
                                                    <i class="ft-maximize"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a data-action="close">
                                                    <i class="ft-x"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                          
                                <div class="card-content collapse show">
                                    <div class="card-body " >
                                        <div class="card-text">
                                            @if(\Session::has('success'))
                                                <div class="alert alert-success">
                                                        {{\Session::get('success')}}
                                                </div>
                                            @endif
                                            @if($errors->all())
                                                <div class="alert alert-danger">
                                                    @foreach($errors->all() as $error)
                                                
                                                    <p>{{$error}}</p> 
                                            
                                                    @endforeach
                                                </div>
                                            @endif
                                                <!--p>This is the most basic and default form having form section.</p-->
                                        </div>
                                        <div class="table-responsive">

                                        
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="text-align: center;">Customer Details</th>
                                                </tr>
                                                <tr>
                                                    <th>First Name</th><td>{{ $enquiry->first_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Last Name</th><td>{{ $enquiry->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th><td>{{ $enquiry->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Mobile No.</th><td>{{ $enquiry->mobile_no }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Company</th><td>{{ $enquiry->company }}</td>
                                                </tr>
                                            </thead>

                                            <tbody>
                                              
                                                @php
                                                    $product_name = '';
                                                    $quantity_total = 0;
                                                    $products = json_decode($enquiry->products, true);
                                                    $quantities  = json_decode($enquiry->quantity, true);
                                                @endphp
                                               
                                                                                
                                                    @foreach($products as $product_type => $product)
                                                    <tr><th>Product Type</th><td>     {{ ucfirst($product_type) }}</td><tr>
                                                    <tr><th colspan="2" style="text-align: center">Product Details</th></tr>
                                                    <tr><th>S. No.</th><th>Attributes</th></tr>

                                                    @php
                                                    $i= 1;
                                                    $quantity_total = 0;
                                                    @endphp
                                                        @foreach($product as $no => $attribute_values)
                                                        <tr>
                                                        <td>{{  $i }}</td>
                                                        <td>
                                                            @php    
                                                                $attributes = $attribute_values_arr = [];

                                                                foreach($attribute_values as $attribute_value){
                                                            
                                                                    $attr_value = \App\Models\AttributeValue::with('attribute')->where('id', $attribute_value)->orderBy('display_order', 'ASC')->first();
                                                                    
                                                                    $attr_name = $attr_value->attribute->name;
                                                                    $attr_val= $attr_value->value;

                                                                    $attributes[] = '<strong>'.$attr_name.'</strong>: '.$attr_val; 
                                                                }
                                                            @endphp
                                                                
                                                            @foreach($attributes as $attr)
                                                                <div>
                                                                    {!! $attr !!}
                                                                </div>
                                                                
                                                            
                                                            @endforeach
                                                            @php
                                                                if(!empty($quantities[$product_type][$no])){
                                                                    $quantity_total += (int)$quantities[$product_type][$no];
                                                                }
                                                                $i++;
                                                            @endphp
                                                            <div>
                                                               <strong>Quantity: </strong> {{ (int)$quantities[$product_type][$no] }}
                                                            </div>
                                                            </td>   
                                                        </tr>
                                                       
                                                        @endforeach
                                                        
                                         
                                                        <tr><th>Total {{ ucfirst($product_type).'s'}}<td>{{ $quantity_total }}</td>
                                                        <tr rowspan="2"><td colspan="2"></td></tr>
                                                    @endforeach
                                                   

                                              

                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
       
    <!-- END: Content-->

@endsection
