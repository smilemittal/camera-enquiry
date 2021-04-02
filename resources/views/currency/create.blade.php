@extends('layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            {{-- <h4 class="content-header-title" id="basic-layout-form">{{ translate('Products') }}</h4> --}}
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ translate('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('currency.index') }}">{{ translate('List') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ translate('Add') }}
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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form">{{ translate('Add') }}</h4>
                            <a class="heading-elements-toggle">
                                <i class="la la-ellipsis-v font-medium-3"></i>
                            </a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <a data-action="expand">
                                        <i class="ft-maximize"></i>
                                    </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body ">
                                <div class="card-text">
                                    @if (\Session::has('success'))
                                        <div class="alert alert-success">
                                            {{ \Session::get('success') }}
                                        </div>
                                    @endif
                                    @if ($errors->all())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)

                                                <p>{{ $error }}</p>

                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <form action="{{ route('currency.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title h6">{{translate('Add New Currency')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-from-label" for="name">{{translate('Name')}}</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-from-label" for="symbol">{{translate('Symbol')}}</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="{{translate('Symbol')}}" id="symbol" name="symbol" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-from-label" for="code">{{translate('Code')}}</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="{{translate('Code')}}" id="code" name="code" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-from-label" for="exchange_rate">{{translate('Exchange Rate')}}</label>
                                            <div class="col-sm-10">
                                                <input type="number" step="0.01" min="0" placeholder="{{translate('Exchange Rate')}}" id="exchange_rate" name="exchange_rate" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{__('site.Status')}}</label>
                                            <select id="status" name="status" class="form-control">
                                                 @foreach($status as $status)
                                                 @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic form layout section end -->
    </div>

    <!-- END: Content-->

@endsection

@section('scripts')
    <script>
        // $('#type').on('change', function(){
        //     var type = $(this).val();
        //     var system_type_id = $("#system_type_id option:selected").val();

        //     $.ajax({
        //         method: 'post',
        //         url: '{{ route('get-product-attributes') }}',
        //         data: {
        //             'type': type,
        //             'system_type_id': system_type_id,
        //             '_token': '{{ csrf_token() }}',
        //         },
        //         success: function(data){

        //             if(data.html != ''){
        //                 $('#product_attribute_div').empty();
        //                 $('#product_attribute_div').append(data.html);
        //                 $('#add-attributes-div').show();   
        //             }else{
        //                 $('#add-attributes-div').hide();
        //             }
        //         }
        //     });
        // });
        $('#system_type_id').on('change', function() {

            var system_type_id = $(this).val();;

            $.ajax({
                method: 'post',
                url: '{{ route('get-standard-attributes') }}',
                data: {

                    'system_type_id': system_type_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(data) {
                    if (data.html != '') {
                        $('#standard_id option:gt(0)').remove();
                        $('#standard_id').append(data.html);
                        //$('#add-attributes-div').show();   
                    }
                    // else{
                    //     $('#add-attributes-div').hide();
                    // }
                }
            });
        });
        // $('#system_type_id').on('change', function(){
        //     var type = $("#type option:selected").val()
        //     var system_type_id = $(this).val();;

        //     $.ajax({
        //         method: 'post',
        //         url: '{{ route('get-product-attributes') }}',
        //         data: {
        //             'type': type,
        //             'system_type_id': system_type_id,
        //             '_token': '{{ csrf_token() }}',
        //         },
        //         success: function(data){
        //             if(data.html != ''){
        //                 $('#product_attribute_div').empty();
        //                 $('#product_attribute_div').append(data.html);
        //                 $('#add-attributes-div').show();   
        //             }else{
        //                 $('#add-attributes-div').hide();
        //             }
        //         }
        //     });
        // });
        $('#type_id').on('change', function() {
            var type = $("#type_id option:selected").val()
            var type_id = $(this).val();;

            $.ajax({
                method: 'post',
                url: '{{ route('get-product-attributes') }}',
                data: {
                    'type': type,
                    'type_id': type_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(data) {
                    if (data.html != '') {
                        $('#product_attribute_div').empty();
                        $('#product_attribute_div').append(data.html);
                        $('#add-attributes-div').show();
                    } else {
                        $('#add-attributes-div').hide();
                    }
                }
            });
        });

    </script>

@endsection
