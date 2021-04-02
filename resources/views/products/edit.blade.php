@extends('layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h4 class="content-header-title" id="basic-layout-form"> {{ translate('Products') }}</h4>
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ translate('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ translate('List') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ translate('Edit') }}
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
                            <h4 class="card-title" id="basic-layout-form">{{ translate('Edit') }}</h4>

                            <a class="heading-elements-toggle">
                                <i class="la la-ellipsis-v font-medium-3"></i>
                            </a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
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
                                    <!--p>This is the most basic and default form having form section.</p-->
                                </div>
                                <form method="post" action="{{ route('products.update', $product->id) }}" class="form">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="Name">{{ translate('Product Name') }}</label>
                                            <input type="text" id="name" class="form-control" value="{{ $product->name }}"
                                                name="name">
                                        </div>

                                        <div class="form-group">
                                            <label for="system_type_id">{{ translate('System Type') }}</label>
                                            <select name="system_type_id" id="system_type_id" class="form-control">
                                                <option value="">{{ translate('Select') }}</option>
                                                @foreach ($system_types as $system_type)
                                                    <option value="{{ $system_type->id }}" @if ($product->system_type_id == $system_type->id) selected @endif>{{ $system_type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="standard_id">{{ translate('Standard') }}</label>
                                            <select name="standard_id" id="standard_id" class="form-control">
                                                <option value="">{{ translate('Select') }}</option>
                                                @foreach ($standards as $standard)
                                                    <option value="{{ $standard->id }}" @if ($product->standard_id == $standard->id) selected @endif>{{ $standard->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="type">{{ translate('Type') }}</label>
                                            <select name="type_id" id="type_id" class="form-control">
                                                <option value="">{{ translate('Select') }}</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}" @if ($product->type_id == $type->id) selected @endif>{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if(!empty($currencies) && count($currencies))
                                            @foreach($currencies as $currency)
                                            <div class=" form-group">
                                                <label for="price">{{ translate('Price For: '.strtoupper($currency->code)) }}</label>
                                                <input type="number" class="form-control" name="price[{{ strtoupper($currency->code) }}]"
                                                    placeholder="{{translate('Price')}}">
                                            </div>
                                            @endforeach
                                        @else
                                            <div class=" form-group">
                                                <label for="price">{{ translate('Price For: '.strtoupper($currency->code)) }}</label>
                                                <input type="number" class="form-control" name="price[{{ strtoupper(default_language()) }}]"
                                                    placeholder="{{translate('Price')}}">
                                            </div>
                                        @endif
                                        <div class=" form-group">
                                            <label for="priority">{{ translate('Priority') }}</label>
                                            <input type="number" id="priority" class="form-control"
                                                value="{{ $product->priority }}" name="priority">

                                        </div>
                                        <hr>
                                        <div>
                                            <h5> {{ translate('Add Product Attributes') }}</h5>

                                            <div id="product_attribute_div">
                                                @foreach ($attributes as $attribute)
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" id="attribute"
                                                                    data-attribute_id="{{ $attribute->id }}"
                                                                    value="{{ $attribute->name }}" readonly
                                                                    class="form-control">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">

                                                                <select name="attribute_value[{{ $attribute->id }}]"
                                                                    id="" class="form-control">
                                                                    <option value="">{{ translate('Select') }}</option>

                                                                    @if (!empty($attribute->attribute_values))

                                                                        @foreach ($attribute->attribute_values as $value)
                                                                            <option value="{{ $value->id }}" @if (!empty($attribute_value_ids) && in_array($value->id, $attribute_value_ids)) selected @endif>
                                                                                {{ $value->value }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-actions" style="text-align:center">

                                            <button type="reset" class="btn btn-danger">
                                                <i class=""></i>{{ translate('Reset') }}
                                            </button>

                                            <button type="submit" name="submit" class="btn btn-success">
                                                <i class=""></i>{{ translate('Save') }}
                                            </button>
                                        </div>
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
        $('#type_id').on('change', function() {
            var type = $(this).val();
            var system_type_id = $("#system_type_id option:selected").val();

            $.ajax({
                method: 'post',
                url: '{{ route('get-product-attributes') }}',
                data: {
                    'type': type,
                    'system_type_id': system_type_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log(data);
                    $('#product_attribute_div').empty();
                    $('#product_attribute_div').append(data.html);
                }
            });
        });
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
        //     var type = $("#type_id option:selected").val()
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
        //             console.log(data);
        //             $('#product_attribute_div').empty();
        //             $('#product_attribute_div').append(data.html);
        //         }
        //     });
        // });

    </script>
@endsection
