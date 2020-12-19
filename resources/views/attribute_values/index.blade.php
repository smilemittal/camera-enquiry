@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection  
@section('content') 
<!--BEGIN content-->
<div class="row">
    <div class="content-header-left col-md-4 col-12 mb-2">
        <h3 class="content-header-title">{{__('site.Attribute Value')}}</h3>
    </div>
    <div class="content-header-right col-md-8 col-12">
        <div class="breadcrumbs-top float-md-right">
            <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{__('site.Home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('site.List')}}
                    </li>
                </ol>
            </div>
        </div>
    </div>
    </div>
<div class="content-body">
                <!--Form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">{{__('site.List')}}</h4>

                                </div>
                                <!--Card Content body start-->
                                <div class="card-content collapse show">
                                <div class="card-body">
                                    @if(\Session::has('success'))
                                    <div class="alert alert-success">
                                        {{\Session::get('success')}}
                                    </div>
                                @endif
                                @if(\Session::has('updated'))
                                    <div class="alert alert-warning">
                                        {{\Session::get('updated')}}
                                    </div>
                                @endif
                                @if(\Session::has('delete'))
                                    <div class="alert alert-danger">
                                        {{\Session::get('delete')}}
                                    </div>
                                @endif
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration" id="attribute-values" style="width: 100%; display: table;">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('site.id')}}</th>
                                                    <th>{{ __('site.attribute')}}</th>
                                                    <th>{{__('site.value')}}</th>
                                                    <th>{{ __('site.display_order')}}</th>
                                                    <th>{{ __('site.system_type')}}</th>
                                                    <th>{{ __('site.action')}}</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>{{ __('site.id')}}</th>
                                                    <th>{{ __('site.attribute')}}</th>
                                                    <th>{{__('site.value')}}</th>
                                                    <th>{{ __('site.display_order')}}</th>
                                                    <th>{{ __('site.system_type')}}</th>
                                                    <th>{{ __('site.action')}}</th>
                                                </tr>
            
                                            </tfoot>
                                        </table>
                                    <div>
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
    <script src="https://unpkg.com/promise-polyfill" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.js')}}" type="text/javascript"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(document).ready(function(){
            // Data table for serverside
            $('#attribute-values').DataTable({
                "pageLength": 25,
                "order": [[ 0, 'desc' ]],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ route('get.attribute_values') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}",route:'{{route('attribute-values.index')}}'}
                },
                "columns": [
                    { "data": "id" },
                    { "data": "attribute_id" },
                    { "data": "value" },
                    { "data": "display_order" },
                    { "data": "system_type_id" },
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
