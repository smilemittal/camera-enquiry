@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
@section('content')
    <!--BEGIN content-->
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
    <div class="row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">{{ translate('Type') }}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ translate('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ translate('List') }}
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
                        <div class="card-header" style="height: 50px;">
                            <div class="card-title layout_btns" id="basic-layout-form">
                                <h3>{{ translate('List') }}</h3>
                                <div class="btns-right-side">
                                    <a href="{{ route('types.create') }}" method="post"
                                        class="btn mr-1 mb-1 btn-success btn-sm" type="submit">{{ translate('Add') }} </a>
                                    <a href="{{ route('types.import') }}" method="post"
                                        class="btn mr-1 mb-1 btn-primary btn-sm" type="submit">{{ translate('Import') }}
                                    </a>
                                    <a href="{{ route('types.export') }}" method="post"
                                        class="btn mr-1 mb-1 btn-danger btn-sm"
                                        type="submit">{{ translate('Export') }}</a>
                                    <button type="button" id="deleteTrigger"
                                        class="btn mr-1 mb-1 btn-danger btn-sm">{{ translate('Delete Selected') }}</button>
                                </div>
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
                                    <div class="alert alert-success">
                                        {{ \Session::get('updated_success') }}
                                    </div>
                                @endif
                                @if (\Session::has('deleted_success'))
                                    <div class="alert alert-success">
                                        {{ \Session::get('deleted_success') }}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <form class="form" action="{{ route('types.multipledelete') }}" method="post"
                                        id='delete_all'>
                                        @csrf
                                        <table class="table table-striped table-bordered zero-configuration" id="types"
                                            style="width: 100%; display: table;">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" name="" class="checkboxes" id="checkAll" />
                                                    </th>
                                                    <th>{{ translate('ID') }}</th>
                                                    <th>{{ translate('Name') }}</th>
                                                    <th>{{ translate('Slug') }}</th>
                                                    <th>{{ translate('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th><input type="checkbox" name="" class="checkboxes" id="checkAll" />
                                                    </th>
                                                    <th> {{ translate('ID') }}</th>
                                                    <th> {{ translate('Name') }} </th>
                                                    <th>{{ translate('Slug') }}</th>
                                                    <th> {{ translate('Action') }}</th>
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
    <script src="https://unpkg.com/promise-polyfill" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.js') }}" type="text/javascript"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(document).ready(function() {
            // Data table for serverside
            $('#types').DataTable({
                "pageLength": 40,
                "order": [
                    [1, 'desc']
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('get.types') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        route: '{{ route('types.index') }}'
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
                        "data": "slug"
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
        //  $('#deleteTrigger').on('click',function () {
        //      $('#delete_all').submit();
        //  });
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
