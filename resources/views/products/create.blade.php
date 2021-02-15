@extends('layouts.app')

@section('content')
    <!-- BEGIN: Content-->
            <div class="content-header row">
                <div class="content-header-left col-md-4 col-12 mb-2">
                    <h4 class="content-header-title" id="basic-layout-form">{{ translate('Products')}}</h4>
                </div>
                <div class="content-header-right col-md-8 col-12">
                    <div class="breadcrumbs-top float-md-right">
                        <div class="breadcrumb-wrapper mr-1">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{ translate('Home')}}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ translate('List')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ translate('Add')}}
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
                                    <h4 class="card-title" id="basic-layout-form">{{ translate('Add')}}</h4>
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
                                        </div>
                                        <form method="post" action="{{ route('products.store') }}" class="form" >
                                        @csrf
                                            <div class="form-body">
                                                {{-- <div class="form-group">
                                                    <label for="Name">{{ translate('product_name')}}</label>
                                                    <input type="text" id="name" class="form-control" placeholder="name" name="name">
                                                </div> --}}
                                                <div class="form-group {{ $errors->get('name') ? 'has-error' : '' }}">
                                                    <label for="name">{{ translate('Name') }}</label>
                                                    <input type="text" name="name" placeholder="Name" class="form-control" required>
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="system_type_id">{{ translate('System Type')}}
                                                    </label>
                                                    <select name="system_type_id" id="system_type_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach($system_types as $system_type)
                                                            <option value="{{ $system_type->id }}">{{ $system_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>    

                                                <div class="form-group">
                                                    <label for="standard_id">{{ translate('Standard')}}</label>
                                                    <select name="standard_id" id="standard_id" class="form-control">
                                                        <option value="">Select</option>
                                                        {{-- @foreach($standards as $standard)
                                                            <option value="{{ $standard->id }}">{{ $standard->name }}</option>
                                                        @endforeach --}}
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="type">{{ translate('Type')}}</label>
                                                    <select name="type_id" id="type_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach($types as $type)
                                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class=" form-group">
                                                    <label for="priority">{{ translate('Priority')}}</label>
                                                    <input type="number" class="form-control"  name="priority" placeholder="Priority">
                                                </div>
                                                <hr>
                                                <div id="add-attributes-div" style="display: none;">
                                                   <h5>Add Product Attributes</h5>

                                                   <div id="product_attribute_div">
                                                   </div>
                                                </div>
                                               
                                                <div class="form-actions" style="text-align:center">
                                                    <button type="reset"  class="btn btn-danger">
                                                        {{translate('Reset')}}
                                                    </button>            
                                                        <button type="submit" name="submit" class="btn btn-success">
                                                            {{ translate('Save')}}
                                                        </button>
                                                <div>
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
        $('#system_type_id').on('change', function(){
          
            var system_type_id = $(this).val();;

            $.ajax({
                method: 'post',
                url: '{{ route('get-standard-attributes') }}',
                data: {
                   
                    'system_type_id': system_type_id,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(data){
                    if(data.html != ''){
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
        $('#type_id').on('change', function(){
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
                success: function(data){
                    if(data.html != ''){
                        $('#product_attribute_div').empty();
                        $('#product_attribute_div').append(data.html);
                        $('#add-attributes-div').show();   
                    }else{
                        $('#add-attributes-div').hide();
                    }
                }
            });
        });
    </script>

@endsection