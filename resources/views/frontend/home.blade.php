@extends('frontend.layouts.app')
@section('content')
        <div class="form-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-radius-box">
                            <div class="heading-btns">
                                <h3>Wybierz rodzaj systemu</h3>
                                <div class="col-kemey col-kemey-two">
                                    <div class="row d-flex align-items-center">
                                        <input type="hidden" id="selected_system_type" name="selected_system_type" value="">
                                        @foreach($system_types as $system_type) 
                                            <div class="col-xl-3 col-md-6">
                                                <button class="system_type" data-id="{{ $system_type->id }}">{{ $system_type->name }}</button>
                                            </div>
                                        @endforeach
                                     
                                        <div class="col-xl-6 col-md-12 pl-xl-3">
                                            <p class="ml-xl-5 pl-xl-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="heading-btns three-btn-under">
                            <h3>LOREM IPSUM</h3>
                            <div class="col-kemey col-kemey-two">
                                <div class="row d-flex align-items-center">
                                    <input type="hidden" id="selected_standard" name="selected_standard" value="">
                                    @foreach($standards as $standard)
                                        <div class="col-xl-3 col-md-4">
                                        <button class="standard" data-id="{{ $standard->id }}">{{ $standard->name }}</button>
                                        </div>
                                    @endforeach
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="kemey-cameras-sec">
            <div class="container">
                <div class="col-kemey">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-md-6">
                            <a class="btn" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">kamery / Cameras</a>
                        </div>
                        <div class="col-xl-2 col-md-6">
                            <div class="kamaroty">
                                <input type="text" name="" />
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-7 pl-lg-3">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">
                            <input type="hidden" name="selected_camera_attribute">
                            <div class="row" id="camera_attribute_div">
                                @if(!empty($attribute_camera))
                                {!! $attrribute_camera !!}
                                @endif
                            </div>

                            <p class="earch">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

                            <div class="col-kemey kemey-boxbtn">
                                <div class="row d-flex align-items-center">
                                    <div class="col-xl-3 col-md-6">
                                        <button>Kamey / Cameras</button>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <button>Kamey / Cameras</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-kemey">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-md-6">
                            <a class="btn" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">kamery / Cameras</a>
                        </div>
                        <div class="col-xl-2 col-md-6">
                            <div class="kamaroty">
                                <input type="text" name="" />
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-7 pl-lg-3">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <div class="card card-body">
                            <div class="row" id="recorder_attribute_div">
                                @if(!empty($attribute_recorder))
                                {!! $attribute_recorder !!}
                                @endif
                            </div>

                            <p class="earch">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

                            <div class="col-kemey kemey-boxbtn">
                                <div class="row d-flex align-items-center">
                                    <div class="col-xl-3 col-md-6">
                                        <button>Kamey / Cameras</button>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <button>Kamey / Cameras</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="three-btn-sec">
            <div class="container">
                <div class="col-kemey">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-md-4">
                            <button>Kamey / Cameras</button>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <button>Kamey / Cameras</button>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <button>Kamey / Cameras</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
    $('.system_type').on('click', function(){
        var system_type = $(this).data('id');
        $('#selected_system_type').val(system_type);
    });  

    $('.standard').on('click', function(){
        var standard = $(this).data('id');
         var system_type = $('#selected_system_type').val();
        $('#selected_standard').val(standard);


        $.ajax({
            method:'post',
            url: '{{ route('get-enquiry-attributes') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'system_type': system_type,
                'standard': standard,
            },
            success: function(data){
                if(data.html_camera != ''){
                    $('#camera_attribute_div').empty();
                    $('#camera_attribute_div').append(data.html_camera);
                }
                if(data.html_recorder != ''){
                    $('#recorder_attribute_div').empty();
                    $('#recorder_attribute_div').append(data.html_recorder);
                }
            },
            
        });



    });   

    $(document).on('change', '.attribute',function(){
        var attribute_value_arr = [];
        var cam_attribute_value_arr  = [];
        var rec_attribute_value_arr = [];
        console.log($(this).data('product_type'));
        $('select[name="attributes[]"] option:selected').each(function(){
           
            if($(this).val()){
                if($(this).data('product_type') == 'camera'){
                    
                    cam_attribute_value_arr.push($(this).val());
                }else{
                    rec_attribute_value_arr.push($(this).val());
                }
            }
            
        
        });
        
        if($(this).data('product_type') == 'camera'){
            var attribute_val = cam_attribute_value_arr.join(','); 
        }else{
            var attribute_val = rec_attribute_value_arr.join(',');
        }
     
        

        var system_type = $(this).data('system_type');
        var product_type = $(this).data('product_type');
    
        $.ajax({
            method: 'post',
            url: '{{ route('update-attributes') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'attribute_value' : attribute_val,
                'system_type': system_type,
                'product_type': product_type
            },
            success: function(data){
                if(data.success == true){
                    if(data.product_type == 'camera'){
                        $('#camera_attribute_div').empty();
                        $('#camera_attribute_div').append(data.html);
                    }else if(data.product_type == 'recorder'){
                        $('#recorder_attribute_div').empty();
                        $('#recorder_attribute_div').append(data.html);
                    }
                }
            }
        });

    });





</script>
@endsection