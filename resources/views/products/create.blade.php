@extends('layouts.app')

@section('content')

    <!-- BEGIN: Content-->

            
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> Add Product</h4>
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
                                        <form method="post" action="{{ route('product.store') }}" class="form" >
                                        @csrf
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="Name">Product Name</label>
                                                    <input type="text" id="name" class="form-control" placeholder="name" name="name">
                                                </div>   

                                                <div class="form-group">
                                                    <select name="type" id="type" class="form-control">
                                                            <option value="">Select</option>  
                                                            <option value="camera">Camera</option>
                                                            <option value="nvr">Nvr</option>
                                                            <option value="recorder">Recorder</option>
                                                            <option value="switch">Switch</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select name="system_type_id" id="system_type_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach($system_types as $system_type)
                                                            <option value="{{ $system_type->id }}">{{ $system_type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <hr>
                                                <div id="add-attributes-div" style="display: none;">
                                                   <h5>Add Product Attributes</h5>

                                                   <div id="product_attribute_div">

                                                   </div>
                                                </div>
                                               
                                                <div class="form-actions" style="text-align:center">
                                                        <a  class=" btn btn-primary" href="{{ route('product.index') }}"> View All</a>           
                                                        <button type="submit" name="submit" class="btn btn-success">
                                                            Save
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
        $('#type').on('change', function(){
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

        $('#system_type_id').on('change', function(){
            var type = $("#type option:selected").val()
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
