@extends('layouts.app')

@section('content')

    <!-- BEGIN: Content-->
    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">{{ translate('Enquiries')}}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="#">{{ translate('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ translate('List')}}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

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
                                        <a data-action="expand">
                                            <i class="ft-maximize"></i>
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
                                            <th colspan="2" style="text-align: center;">{{translate('Customer Details')}}</th>
                                        </tr>
                                        <tr>
                                            <th>{{translate('First Name')}}</th><td>{{ $enquiry->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{translate('Last Name')}}</th><td>{{ $enquiry->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{translate('Email')}}</th><td>{{ $enquiry->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{translate('Mobile No.')}}</th><td>{{ $enquiry->mobile_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{translate('Company')}}</th><td>{{ $enquiry->company }}</td>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php
                                            $products = json_decode($enquiry->products, true);
                                            $quantities  = json_decode($enquiry->quantity, true);
                                            $total_price = 0;
                                            $total_qty = 0;
                                        @endphp
                                        @foreach($products as $product_type => $product)
                                            @if(!empty($quantities[$product_type]['total'] ) && $quantities[$product_type]['total'] != 0)
                                                <tr><th colspan="4" style="border: 1px solid #000; text-align: center;">{{translate('Chosen ').' '.ucfirst($product_type) }}</td></tr>
                                                <tr><th style="border: 1px solid #000;text-align: center;">{{translate('Model')}}</th><th style="border: 1px solid #000; text-align: center;">{{translate('Quantity')}}</th><th style="border: 1px solid #000; text-align: center;">{{translate('Price for one')}}</th><th style="border: 1px solid #000; text-align: center;">{{translate('Summary price for all')}}</th></tr>

                                                @php
                                                $quantity_total = 0;
                                                $price_total = 0;
                                                @endphp
                                                @foreach($product as $no => $attribute_values)
                                                <tr>
                                                    <td style="border: 1px solid #000;text-align: center;">{{ $attribute_values['model']['name'] }}</td>
                                                    <td style="border: 1px solid #000;text-align: center;">
                                                        @php
                                                        if(!empty($quantities[$product_type][$no])){
                                                            $quantity_total += (int)$quantities[$product_type][$no]['total_qty'];
                                                            $price_total += $attribute_values['model']['price'] * (int)$quantities[$product_type][$no]['total_qty'];
                                                            $total_price += $attribute_values['model']['price'] * (int)$quantities[$product_type][$no]['total_qty'];
                                                            $total_qty += (int)$quantities[$product_type][$no]['total_qty'];
                                                        }
                                                        @endphp
                                                        @if(!empty($quantities[$product_type][$no]['total_qty']))
                                                            {{ (int)$quantities[$product_type][$no]['total_qty'] }}
                                                        @endif
                                                    </td>
                                                    <td style="border: 1px solid #000;text-align: center;">
                                                        {{$attribute_values['model']['price']}}
                                                    </td>
                                                    <td style="border: 1px solid #000;text-align: center;">
                                                        {{$attribute_values['model']['price'] * (int)$quantities[$product_type][$no]['total_qty'] }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <tr><th style="border: 1px solid #000;text-align: center;">{{translate('Total')}} {{ ucfirst($product_type).'s'}}</th><td  style="border: 1px solid #000;text-align: center;">{{ $quantity_total }}</td>
                                                    <td  style="border: 1px solid #000;text-align: center;"></td>
                                                    <td  style="border: 1px solid #000;text-align: center;">{{ $price_total }}</td></tr>
                                            @endif
                                        @endforeach
                                        <tr><th style="border: 1px solid #000;text-align: center;" colspan="3">{{translate('Summary Price for all products')}}</th>
                                        <td  style="border: 1px solid #000;text-align: center;">{{ $total_price }}</td></tr>
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

