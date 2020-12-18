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
                                <div class="card-header"style="height: 50px;">
                                    <div class="card-title layout_btns" id="basic-layout-form">
                                        <h3>All Products</h3>
                                            <div class="btns-right-side">
                                                <a href="{{ route('product-attributes.import')}}" method="post" class="btn mr-1 mb-1 btn-primary btn-sm" type="submit" >Import </a> 
                                                <a href="{{ route('product-attributes.export')}}" method="post" class="btn mr-1 mb-1 btn-danger btn-sm" type="submit" > Export</a>
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
                                   
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered zero-configuration" style="width:100%; display:table;"  id="product">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th> Name</th>
                                                        <th>Action</th>
                                              
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th> Name</th>
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
            $('#product').DataTable({
                "pageLength": 25,
                "order": [[ 0, 'desc' ]],
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ route('get.product') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}",route:'{{route('products.index')}}'}
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
