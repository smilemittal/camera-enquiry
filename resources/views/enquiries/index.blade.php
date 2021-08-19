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
            #checkAll {
    width: auto  !important;
}
        </style>

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
                                    <div class="card-title layout_btns" id="basic-layout-form">
                                        <h4>{{translate('Enquiries')}}</h4>
                                        <button type="button" id="deleteTrigger" class="btn mr-1 mb-1 btn-danger btn-sm" >{{translate('Delete Selected')}}</button>
                                   
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
                                            <form class="form" action="{{ route('enquiries.multipledelete') }}" method="post" id="{{ 'delete_all' }}">
                                                @csrf
                                            <table class="table table-striped table-bordered zero-configuration" id="enquiries">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" name="" class="checkboxes" id="checkAll" /></th>
                                                        <th>{{ translate('ID')}}</th>
                                                        <th>{{ translate('Name')}}</th>
                                                        <th>{{ translate('Email')}}</th>
                                                        <th>{{ translate('Mobile No.')}}</th>
                                                        {{-- <th>{{ translate('Company')}}</th>
                                                        <th>{{ translate('Product')}}</th>
                                                        <th>{{ translate('System Type')}}</th>
                                                        <th>{{ translate('Standard')}}</th> --}}
                                                        <th>{{ translate('Date')}}</th>
                                                        <th>{{ translate('Action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th><input type="checkbox" name="" class="checkboxes" id="checkAll" /></th>
                                                        <th>{{ translate('ID')}}</th>
                                                        <th>{{ translate('Name')}}</th>
                                                        <th>{{ translate('Email')}}</th>
                                                        <th>{{ translate('Mobile No.')}}</th>
                                                        {{-- <th>{{ translate('Company')}}</th>
                                                        <th>{{ translate('Product')}}</th>
                                                        <th>{{ translate('System Type')}}</th>
                                                        <th>{{ translate('Standard')}}</th> --}}
                                                        <th>{{ translate('Date')}}</th>
                                                        <th>{{ translate('Action')}}</th>
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
                "pageLength": 40,
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
                    { "data": "#" },
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
                        aTargets: [ -1,0 ]
                    }
                ]
            });
        });
    </script>
    <script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>
    <script>
        $('.checkboxes').click(function () {    
     $('input:checkbox').prop('checked', this.checked);    
 });
 $(document).on('click','.page-link',function () {    

     $('.checkboxes').removeAttr('checked');    
 });
 $('#deleteTrigger').on('click',function () { 
    swal({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: true,
        closeOnCancel: true
    }).then(function (isConfirm) {
        if (isConfirm.value) {
          $('#delete_all').submit();        
        }
    }).catch(swal.noop)
  });

        </script>
@endsection
