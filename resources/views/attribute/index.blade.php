@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
@section('content')
    <style>
        #checkAll {
            width: auto !important;
        }

        .layout_btns {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

    </style>
    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">{{ translate('Attributes') }}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="#">{{ translate('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ translate('List') }}
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
                        <div class="card-header" style="height:50px;">
                            <div class="card-title layout_btns" id="basic-layout-form">

                                <h4>{{ translate('List') }}</h4>
                                <div class="btns-right-side">
                                    <a href="{{ route('attribute.create') }}" method="post"
                                        class="btn mr-1 mb-1 btn-success btn-sm" type="submit">{{ translate('Add') }}</a>
                                    <a href="{{ route('attribute.import') }}" method="post"
                                        class="btn mr-1 mb-1 btn-primary btn-sm" type="submit">{{ translate('Import') }}
                                    </a>
                                    <a href="{{ route('attribute.export') }}" method="post"
                                        class="btn mr-1 mb-1 btn-danger btn-sm"
                                        type="submit">{{ translate('Export') }}</a>
                                    <button type="button" id="deleteTrigger"
                                        class="btn mr-1 mb-1 btn-danger btn-sm">{{ translate('Delete Selected') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">

                                @if (\Session::has('success'))
                                    <div class="alert alert-success">
                                        {{ \Session::get('success') }}
                                    </div>
                                @endif
                                @if (\Session::has('updated'))
                                    <div class="alert alert-success">
                                        {{ \Session::get('updated') }}
                                    </div>
                                @endif
                                @if (\Session::has('deleted'))
                                    <div class="alert alert-success">
                                        {{ \Session::get('deleted') }}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <form class="form" action="{{ route('attributes.multipledelete') }}" method="post"
                                        id="{{ 'delete_all' }}">
                                        @csrf
                                        <table class="table table-striped table-bordered zero-configuration"
                                            style="width:100%;display:table" id="attribute">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" name="" class="checkboxes" id="checkAll" />
                                                    </th>
                                                    <th>{{ translate('ID') }}</th>
                                                    <th>{{ translate('Attribute Name') }}</th>
                                                    <th>{{ translate('Type ID') }}</th>
                                                    <th>{{ translate('Display Order') }}</th>
                                                    <th>{{ translate('System Type') }}</th>
                                                    <th>{{ translate('Description') }}</th>
                                                    <th>{{ translate('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th><input type="checkbox" name="" class="checkboxes" id="checkAll" />
                                                    </th>
                                                    <th>{{ translate('ID') }}</th>
                                                    <th>{{ translate('Attribute Name') }}</th>
                                                    <th>{{ translate('Type ID') }}</th>
                                                    <th>{{ translate('Display Order') }}</th>
                                                    <th>{{ translate('System Type') }}</th>
                                                    <th>{{ translate('Description') }}</th>
                                                    <th>{{ translate('Action') }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </form>
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
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript">
    </script>
    <!-- BEGIN: Page Vendor JS-->
    <!-- <script src="https://unpkg.com/promise-polyfill" type="text/javascript"></script> -->
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.js') }}" type="text/javascript"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(document).ready(function() {
            // Data table for serverside
            $('#attribute').DataTable({
                "pageLength": 40,
                "order": [
                    [1, 'desc']
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('get.attribute') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        route: '{{ route('attribute.index') }}'
                    }
                },
                "columns": [{
                        "data": "#"
                    },
                    {
                        "data": "id"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "type_id"
                    },
                    {
                        "data": "display_order"
                    },
                    {
                        "data": "system_type_id"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "action"
                    }
                ],
                aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [-1, 0]
                }]
            });
        });

    </script>
    <script src="{{ asset('assets/js/scripts.js') }}" type="text/javascript"></script>
    <script>
        $('.checkboxes').click(function() {
            $('input:checkbox').prop('checked', this.checked);
        });
        $(document).on('click', '.page-link', function() {

            $('.checkboxes').removeAttr('checked');
        });
        $('#deleteTrigger').on('click', function() {
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
            }).then(function(isConfirm) {
                if (isConfirm.value) {
                    $('#delete_all').submit();
                }
            }).catch(swal.noop)
        });

    </script>
@endsection
