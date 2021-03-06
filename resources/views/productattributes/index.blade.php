@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
@section('content')
    <!--BEGIN content-->
    <div class="content-body">
        <!--Form layout section start -->
        <section id="basic-form-layouts">
            <div class="row match-height justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form">{{ translate('Product Attributes') }}</h4>
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
                        <!--Card Content start-->
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @if (\Session::has('success'))
                                    <div class="alert alert-success">
                                        {{ \Session::get('success') }}
                                    </div>
                                @endif
                                @if (\Session::has('updated_success'))
                                    <div class="alert alert-warning">
                                        {{ \Session::get('updated_success') }}
                                    </div>
                                @endif
                                @if (\Session::has('deleted_success'))
                                    <div class="alert alert-danger">
                                        {{ \Session::get('deleted_success') }}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration"
                                        id="productAttributes" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>{{ translate('ID') }}</th>
                                                <th>{{ translate('Product') }}</th>
                                                <th>{{ translate('Attribute') }}</th>
                                                <th>{{ translate('Attribute Value') }}</th>
                                                <th>{{ translate('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>{{ translate('ID') }}</th>
                                                <th>{{ translate('Product') }}</th>
                                                <th>{{ translate('Attribute') }}</th>
                                                <th>{{ translate('Attribute Value') }}</th>
                                                <th>{{ translate('Action') }}</th>
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
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="https://unpkg.com/promise-polyfill" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.js') }}" type="text/javascript"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(document).ready(function() {
            // Data table for serverside
            $('#productAttributes').DataTable({
                "pageLength": 40,
                "order": [
                    [0, 'desc']
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('get.ProductAttributes') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        route: '{{ route('product-attributes.index') }}'
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "product_id"
                    },
                    {
                        "data": "attribute_id"
                    },
                    {
                        "data": "attribute_value_id"
                    },
                    {
                        "data": "action"
                    }
                ],
                aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [-1]
                }]
            });
        });

    </script>
    <script src="{{ asset('assets/js/scripts.js') }}" type="text/javascript"></script>
@endsection
