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
        
            <div class="content-body">
                    <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title layout_btns" id="basic-layout-form">
                                        <h4>{{__('site.attribute')}}</h4>
                                        <div class="btns-right-side">
                                            <a href="{{ route('attribute.import')}}" method="post" class="btn mr-1 mb-1 btn-primary btn-sm" type="submit" >{{ __('site.import')}} </a> 
                                            <a href="{{ route('attribute.export')}}" method="post" class="btn mr-1 mb-1 btn-danger btn-sm" type="submit" >{{ __('site.export')}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                    
                                    @if(\Session::has('success'))
                                        <div class="alert alert-success">
                                            {{\Session::get('success')}}
                                        </div>
                                    @endif
                                    @if(\Session::has('updated'))
                                        <div class="alert alert-warning">
                                            {{\Session::get('success')}}
                                        </div>
                                    @endif
                                    @if(\Session::has('deleted'))
                                        <div class="alert alert-danger">
                                            {{\Session::get('success')}}
                                        </div>
                                    @endif
                                   
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered zero-configuration" style="width:100%" id="attribute">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('site.id')}}</th>
                                                        <th>{{ __('site.attribute_name')}}</th>
                                                        <th>{{__('site.type')}}</th>
                                                        <th>{{ __('site.display_order')}}</th>
                                                        <th>{{ __('site.system_type')}}</th>
                                                        <th>{{ __('site.action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   

                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                        <th>{{ __('site.id')}}</th>
                                                        <th>{{ __('site.attribute_name')}}</th>
                                                        <th>{{__('site.type')}}</th>
                                                        <th>{{ __('site.display_order')}}</th>
                                                        <th>{{ __('site.system_type')}}</th>
                                                        <th>{{ __('site.action')}}</th>
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
            $('#attribute').DataTable({
                "pageLength": 25,
                "order": [[ 0, 'desc' ]],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ route('get.attribute') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}",route:'{{route('attribute.index')}}'}
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "type" },
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
