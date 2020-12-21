@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection  
@section('content') 
<!--BEGIN content--> 
<style>
    .layout_btns {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}
</style>
 <div class="content-header row">
                        <div class="content-header-left col-md-4 col-12 mb-2">
                            <h3 class="content-header-title">{{__('site.Standards')}}</h3>
                        </div>
                        <div class="content-header-right col-md-8 col-12">
                            <div class="breadcrumbs-top float-md-right">
                                <div class="breadcrumb-wrapper mr-1">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">{{__('site.Home')}}</a>
                                        </li>
                                        <li class="breadcrumb-item active">{{__('site.List')}}
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
                    <div class="card-header" style="height: 50px;">
                        <div class="card-title layout_btns" id="basic-layout-form">
                            <h3>{{ __('site.List')}}</h3>
                                <div class="btns-right-side">
                                    <a href="{{ route('standards.create')}}" method="post" class="btn mr-1 mb-1 btn-success btn-sm" type="submit" >{{ __('site.Add')}} </a> 
                                    <a href="{{ route('standards.import')}}" method="post" class="btn mr-1 mb-1 btn-primary btn-sm" type="submit" >{{ __('site.Import')}} </a> 
                                    <a href="{{ route('standards.export')}}" method="post" class="btn mr-1 mb-1 btn-danger btn-sm" type="submit" > {{ __('site.Export')}}</a>

                                </div>
                        </div>
                    </div>
                    <!--Card Content start-->
                    <div class="card-content collapse show">
	                    <div class="card-body">
	                        @if(\Session::has('success'))
                                <div class="alert alert-success">
                                    {{\Session::get('success')}}
                                </div>
                            @endif
                             @if(\Session::has('updated'))
                                        <div class="alert alert-success">
                                            {{\Session::get('updated')}}
                                        </div>
                                    @endif
                                    @if(\Session::has('deleted'))
                                        <div class="alert alert-success">
                                            {{\Session::get('deleted')}}
                                        </div>
                                    @endif
	                        <div class="table-responsive">
	                            <table class="table table-striped table-bordered zero-configuration"style="width:100%" id="standard" >
	                                <thead>
	                                    <tr>
	                                        <th>{{ __('site.ID') }}</th>
	                                        <th>{{ __('site.Name') }}</th>
	                                        <th>{{ __('site.Action') }}</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
                                        
	                                </tbody>
	                                <tfoot>
	                                    <tr>
	                                        <th>{{ __('site.ID') }}</th>
	                                        <th>{{ __('site.Name') }}</th>
	                                        <th>{{ __('site.Action') }}</th>
	                                    </tr>
	                                </tfoot>
	                            </table>
	                        </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
            $('#standard').DataTable({
                "pageLength": 25,
                "order": [[ 0, 'desc' ]],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ route('get.standards') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}",route:'{{route('standards.index')}}'}
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
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
