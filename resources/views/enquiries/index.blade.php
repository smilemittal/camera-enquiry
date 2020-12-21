@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
        <style>
            .layout_btns {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            }
        </style>

        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">{{ __('site.Enquiries')}}</h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="#">{{ __('site.Home')}}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('site.List')}}
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
                                    <div class="card-title layout_btns" id="basic-layout-form">
                                        <h4>{{__('site.Enquiries')}}</h4>
                                   
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                    
                                    @if(\Session::has('success'))
                                        <div class="alert alert-success">
                                            {{\Session::get('success')}}
                                        </div>
                                    @endif
                                   
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered zero-configuration" id="enquiries">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('site.ID')}}</th>
                                                        <th>{{ __('site.Name')}}</th>
                                                        <th>{{ __('site.Email')}}</th>
                                                        <th>{{ __('site.Mobile No.')}}</th>
                                                        {{-- <th>{{ __('site.Company')}}</th>
                                                        <th>{{ __('site.Product')}}</th>
                                                        <th>{{ __('site.System Type')}}</th>
                                                        <th>{{ __('site.Standard')}}</th> --}}
                                                        <th>{{ __('site.Date')}}</th>
                                                        <th>{{ __('site.Action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>{{ __('site.ID')}}</th>
                                                        <th>{{ __('site.Name')}}</th>
                                                        <th>{{ __('site.Email')}}</th>
                                                        <th>{{ __('site.Mobile No.')}}</th>
                                                        {{-- <th>{{ __('site.Company')}}</th>
                                                        <th>{{ __('site.Product')}}</th>
                                                        <th>{{ __('site.System Type')}}</th>
                                                        <th>{{ __('site.Standard')}}</th> --}}
                                                        <th>{{ __('site.Date')}}</th>
                                                        <th>{{ __('site.Action')}}</th>
                                                    </tr> 
                                                </tfoot>
                                               
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
    <!-- BEGIN: Page Vendor JS-->
    <!-- <script src="https://unpkg.com/promise-polyfill" type="text/javascript"></script> -->
    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.js')}}" type="text/javascript"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(document).ready(function(){
            // Data table for serverside
            $('#enquiries').DataTable({
                "pageLength": 25,
                "order": [[ 0, 'desc' ]],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ route('get.enquiries') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}",route:'{{route('attribute.index')}}'}
                },
                "columns": [
                    { "data": "id" },
                    { "data": "customer_name" },
                    { "data": "email" },
                    { "data": "mobile_no" },
                    // { "data": "company" },

                    // { "data": "name" },
                  
                    // { "data": "system_type_id" },
                    // { "data": "standard_id" },
                    { "data": "date" },
                    { "data": "action" }
                ],
                aoColumnDefs: [
                    {
                        bSortable: false,
                        aTargets: [ -1 ]
                    }
                ]
            });
        });
    </script>
    <script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>
@endsection
