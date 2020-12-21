@extends('layouts.app')

@section('content')
     <div class="content-body">
                    <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title layout_btns" id="basic-layout-form">
                                        <h4>{{__('site.Attribute')}}</h4>
                                   
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
                                            <table class="table table-striped table-bordered zero-configuration" style="width:100%" id="attribute">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Customer Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Company</th>
                                                        <th>Product</th>
                                                        <th>System ID</th>
                                                        <th>Standard</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Customer Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Company</th>
                                                        <th>Product</th>
                                                        <th>System ID</th>
                                                        <th>Standard</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
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
                    { "data": "company" },

                    { "data": "name" },
                  
                    { "data": "system_type_id" },
                    { "data": "standard_id" },
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
