@extends('layouts.app')
@section('content')
<!-- BEGIN: Content-->
<div class="content-header row">
<div class="content-header-left col-md-4 col-12 mb-2">
    <h3 class="content-header-title">{{translate('Attribute Value')}}</h3>
</div>
<div class="content-header-right col-md-8 col-12">
    <div class="breadcrumbs-top float-md-right">
        <div class="breadcrumb-wrapper mr-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{translate('Home')}}</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('attribute-values.index') }}">{{translate('List')}}</a>
                </li>
                <li class="breadcrumb-item active">{{translate('Add')}}</a>
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
                                    <h4 class="card-title" id="basic-layout-form"> {{ translate('Add')}}</h4>
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
                                        @if($errors->all())
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $error)
                                            <p>{{$error}}</p> 
                                            @endforeach
                                        </div>
                                        @endif
                                        <form class="form" action="{{ route('attribute-values.store') }}" method="post">
                                            @csrf  
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="type">{{ translate('Type')}}</label>
                                                    <select name="type_id" id="type_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach($types as $type)
                                                           <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="system_type_id">{{ translate('System Types')}}</label>
                                                    <select name="system_type_id" id="system_type_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach($system_types as $system_type)
                                                           <option value="{{ $system_type->id }}">{{ $system_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="attribute_id">{{translate('Attribute')}} </label>
                                                    <select name="attribute_id" id="attribute_id" class="form-control">
                                                        @foreach($attributes as $attribute)
                                                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group {{ $errors->get('value') ? 'has-error' : '' }}">
                                                    <label for="name">{{ translate('Value') }}</label>
                                                    <input type="text" name="value" placeholder="Value" class="form-control" required>
                                                  </div>
        
                                                <div class="form-group {{ $errors->get('display_order') ? 'has-error' : '' }}">
                                                <label for="name">{{ translate('Display Order') }}</label>
                                                <input type="text" name="display_order" placeholder="Display Order" class="form-control" required>
                                                </div>
                                                <div class="form-actions" style="text-align: center;">
                                                    <button type="reset" class="btn btn-danger">{{ translate('Reset')}}</button>
                                                    <button type="submit" class="btn btn-success">{{ translate('Save')}}</button>
                                                </div>
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
        $('#type').on('change', function(){
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
                success: function(data){
                        $('#attribute_id').empty();
                        $('#attribute_id').append(data.html);
                     
                    
                }
            });
        });

        $('#system_type_id').on('change', function(){
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
                success: function(data){
                   
                        $('#attribute_id').empty();
                        $('#attribute_id').append(data.html); 
                    
                }
            });
        });
    </script>
@endsection