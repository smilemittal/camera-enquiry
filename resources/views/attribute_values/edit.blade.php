@extends('layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">{{ translate('Attribute Value') }}</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ translate('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('attribute-values.index') }}">{{ translate('List') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ translate('Edit') }}
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
                        <!-- Card content body start -->
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @if ($errors->all())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif
                                <form method="Post" action="{{ route('attribute-values.update', $attribute_value->id) }}">
                                    @method('PATCH')
                                    @csrf
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="type">{{ translate('Type') }}</label>
                                            <select name="type_id" id="type_id" class="form-control">

                                                @foreach ($types as $type)

                                                    <option value="{{ $type->id }}"
                                                        {{ $type->id == $attribute_value->type_id ? 'selected' : '' }}>
                                                        {{ $type->name }}</option>

                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="system_type_id">{{ translate('System Type') }}</label>
                                            <select name="system_type_id" id="system_type_id" class="form-control">

                                                @foreach ($system_types as $system_type)

                                                    <option value="{{ $system_type->id }}"
                                                        {{ $system_type->id == $attribute_value->system_type_id ? 'selected' : '' }}>
                                                        {{ $system_type->name }}</option>

                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="attribute_id">{{ translate('Standard') }} </label>
                                            <select name="standard_id" id="standard_id" class="form-control">
                                                @foreach ($standards as $standard)
                                                    <option value="{{ $standard->id }}" {{ $standard->id == $attribute_value->standard_id ? 'selected': '' }}>{{ $standard->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="attribute_id">{{ translate('Attribute') }} </label>
                                            <select name="attribute_id" id="attribute_id" class="form-control">
                                                @foreach ($attributes as $attribute)
                                                    <option value="{{ $attribute->id }}"
                                                        {{ $attribute->id == $attribute_value->attribute_id ? 'selected' : '' }}>
                                                        {{ $attribute->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="values">{{ translate('Value') }}</label>
                                            <input type="text" class="form-control" placeholder="Value" name="value"
                                                value="{{ $attribute_value->value }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="displayorder">{{ translate('Display Order') }}</label>
                                            <input type="text" class="form-control" placeholder="Display Order"
                                                name="display_order" value="{{ $attribute_value->display_order }}">
                                        </div>

                                    </div>
                                    <div class="form-actions" style="text-align: center;">
                                        <button type="reset" class="btn btn-danger">{{ translate('Reset') }}</button>
                                        {{-- <a href="{{ route('attribute-values.index')}}" method="post" class="btn btn-primary" type="submit">{{translate('view_all')}}</a> --}}
                                        <button type="submit" class="btn btn-success">{{ translate('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        $('#type').on('change', function() {
            var type = $(this).val();
            var system_type_id = $("#system_type_id option:selected").val();

            $.ajax({
                method: 'post',
                url: '{{ route('get-attributes') }}',
                data: {
                    'type': type,
                    'system_type_id': system_type_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(data) {
                    $('#attribute_id').empty();
                    $('#attribute_id').append(data.html);


                }
            });
        });

        $('#system_type_id').on('change', function() {
            var type = $("#type option:selected").val()
            var system_type_id = $(this).val();;

            $.ajax({
                method: 'post',
                url: '{{ route('get-attributes') }}',
                data: {
                    'type': type,
                    'system_type_id': system_type_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(data) {

                    $('#attribute_id').empty();
                    $('#attribute_id').append(data.html);

                }
            });
        });

    </script>
@endsection
