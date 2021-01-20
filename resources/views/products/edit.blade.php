@extends('layouts.app')
@section('content')
    <!-- BEGIN: Content-->
            <div class="content-header row">
                <div class="content-header-left col-md-4 col-12 mb-2">
                    <h4 class="content-header-title" id="basic-layout-form"> {{ __('site.Products')}}</h4>
                </div>
                <div class="content-header-right col-md-8 col-12">
                    <div class="breadcrumbs-top float-md-right">
                        <div class="breadcrumb-wrapper mr-1">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{ __('site.Home')}}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('site.List')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('site.Edit')}}
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
                                    <h4 class="card-title" id="basic-layout-form">{{ __('site.Edit')}}</h4>

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
                                    <div class="card-body " >
                                        <div class="card-text">
                                            @if(\Session::has('success'))
                                                <div class="alert alert-success">
                                                        {{\Session::get('success')}}
                                                </div>
                                            @endif
                                            @if($errors->all())
                                                <div class="alert alert-danger">
                                                    @foreach($errors->all() as $error)
                                                
                                                    <p>{{$error}}</p> 
                                            
                                                    @endforeach
                                                </div>
                                            @endif
                                                <!--p>This is the most basic and default form having form section.</p-->
                                        </div>
                                        <form method="post" action="{{ route('products.update', $product->id) }}" class="form" >
                                        @csrf
                                        @method('PATCH')
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="Name">{{__('site.Product Name')}}</label>
                                                    <input type="text" id="name" class="form-control" value="{{$product->name}}" name="name">
                                                </div> 

                                                <div class="form-group">
                                                    <label for="standard_id">{{ __('site.Standard')}}</label>
                                                    <select name="standard_id" id="standard_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach($standards as $standard)
                                                            <option value="{{ $standard->id }}" @if($product->standard_id == $standard->id) selected @endif>{{ $standard->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="system_type_id">{{ __('site.System Type')}}</label>
                                                    <select name="system_type_id" id="system_type_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach($system_types as $system_type)
                                                            <option value="{{ $system_type->id }}"  @if($product->system_type_id == $system_type->id) selected @endif>{{ $system_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="type">{{ __('site.Type')}}</label>
                                                    <select name="type_id" id="type_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach($types as $type)
                                                            <option value="{{ $type->id }}"  @if($product->type_id == $type->id) selected @endif>{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <hr>
                                                <div>
                                                   <h5> {{ __('site.Add Product Attributes')}}</h5>

                                                   <div id="product_attribute_div">
                                                    @foreach($attributes as $attribute)
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" id="attribute" data-attribute_id="{{ $attribute->id }}" value="{{ $attribute->name }}" readonly class="form-control">
                                                                
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <select name="attribute_value[{{ $attribute->id }}]" id="" class="form-control">
                                                                        <option value="">Select</option>
                                                                        @if(!empty($attribute->attribute_values))
                                                                            @foreach($attribute->attribute_values as $value) 
                                                                                <option value="{{ $value->id }}" @if(!empty($attribute_value_ids) && in_array($value->id, $attribute_value_ids)) selected @endif>{{ $value->value }}</option>
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

                                                    <button type="reset"  class="btn btn-danger">
                                                        <i class=""></i>{{ __('site.Reset')}}
                                                    </button>            

                                                    <button type="submit" name="submit" class="btn btn-success">
                                                        <i class=""></i>{{ __('site.Save')}}
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
        $('#type_id').on('change', function(){
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
                success: function(data){
                    console.log(data);
                    $('#product_attribute_div').empty();
                    $('#product_attribute_div').append(data.html);
                }
            });
        });
        $('#system_type_id').on('change', function(){
            var type = $("#type_id option:selected").val()
            var system_type_id = $(this).val();;
            $.ajax({
                method: 'post',
                url: '{{ route('get-product-attributes') }}',
                data: {
                    'type': type,
                    'system_type_id': system_type_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(data){
                    console.log(data);
                    $('#product_attribute_div').empty();
                    $('#product_attribute_div').append(data.html);
                }
            });
        });
    </script>
@endsection

