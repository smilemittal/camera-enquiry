@extends('frontend.layouts.app')
@section('content')
<form method="post" action="" id="product-enquiry" enctype="multipart/form-data">
        <div class="form-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-radius-box">
                            <div class="heading-btns">
                            <h3>{{ __('site.System Type') }}</h3>
                                <div class="col-kemey col-kemey-two">
                                    <div class="row d-flex align-items-center">
                                        <input type="hidden" id="selected_system_type" name="selected_system_type" value="">
                                        @foreach($system_types as $system_type) 
                                            <div class="col-xl-6 col-md-6">
                                                <button type="button" class="system_type" data-name="{{ $system_type->name }}" data-id="{{ $system_type->id }}">{{ $system_type->name }}</button>
                                            </div>
                                        @endforeach
                                     
                                        <div class="col-xl-6 col-md-12 pl-xl-3">
                                            <p class="ml-xl-5 pl-xl-5">
                                                {{-- Lorem Ipsum is simply dummy text of the printing and typesetting industry.  --}}
                                                {{-- Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, --}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="heading-btns three-btn-under">
                        <h3>{{ __('site.Standard') }}</h3>
                            <div class="col-kemey col-kemey-two">
                                <div class="row d-flex align-items-center">
                                    <input type="hidden" id="selected_standard" name="selected_standard" value="">
                                    @foreach($standards as $standard)
                                        <div class="col-xl-3 col-md-4">
                                        <button type="button" class="standard {{ $standard->name }}" data-name="{{ $standard->name }}" data-id="{{ $standard->id }}">{{ $standard->name }}</button>
                                        </div>
                                    @endforeach
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="camera_count" value="">
        <input type="hidden" name="recorder_count" value="">
        <div class="kemey-cameras-sec">
            <div class="container">
                <div class="col-kemey camera_1">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-md-6">
                            <a class="btn" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">{{ __('site.Cameras') }}</a>
                        </div>
                        <div class="col-xl-2 col-md-6">
                            <div class="kamaroty">
                                <input type="text" name="quantity[camera][1]" class="quantity camera_quantity" placeholder="Qty"/>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-7 pl-lg-3">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">
                            <input type="hidden" name="selected_camera_attributes_1">
                        
                            <div id="camera_attribute_div">
                               
                                    @if(!empty($attribute_camera))
                                    {!! $attrribute_camera !!}
                                    @endif
                               

                            </div>

                            <p class="earch">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

                            <div class="col-kemey kemey-boxbtn">
                                <div class="row d-flex align-items-center">
                                    <div class="col-xl-3 col-md-6">
                                    <button type="button" class="next_type" data-product_type="camera">{{ __('site.Next Type of Cameras') }}</button>
                                    </div>
                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-kemey recorder_1 recorder_btn" style="display:none;">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-md-6">
                        <a class="btn" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">{{ __('site.Recorder') }}</a>
                        </div>
                        <div class="col-xl-2 col-md-6">
                            <div class="kamaroty">
                                <input type="text" name="quantity[recorder][1]" placeholder="Qty"/>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-7 pl-lg-3">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <div class="card card-body">
                            <input type="hidden" name="selected_recorder_attributes_1">
                            <div id="recorder_attribute_div">
                                @if(!empty($attribute_recorder))
                                {!! $attribute_recorder !!}
                                @endif
                            </div>

                            <p class="earch">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

                            <div class="col-kemey kemey-boxbtn">
                                <div class="row d-flex align-items-center">
                                    <div class="col-xl-3 col-md-6">
                                    <button type="button" class="next_type" data-product_type="recorder">{{ __('site.Next Type of Recorder') }}</button>
                                    </div>
                                    {{-- <div class="col-xl-3 col-md-6">
                                        <button>Kamey / Cameras</button>
                                    </div> --}}
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
                        <button type="button" class="save" data-url="{{ route('save-enquiry') }}" data-toggle="modal" data-target="#exampleModal">{{ __('site.Send Enquiry') }}</button>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <button type="button" class="summary" data-url="{{ route('print.enquiries') }}">{{__('site.Summary')}}</button>
                        </div>
                        {{-- <div class="col-xl-3 col-md-4">
                            <button>Kamey / Cameras</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{__('site.Customer Details')}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                 <div class="form-group">
                 <label for="first-name">{{ __('site.First Name') }}</label>
                    <input type="text" name="first_name" class="first-name form-control" id="first-name">
                 </div>
                 <div class="form-group">
                    <label for="last-name">{{ __('site.last Name') }}</label>
                    <input type="text" name="last_name" class="last-name form-control" id="last-name">
                 </div>
                 <div class="form-group">
                    <label for="email">{{ __('site.Email') }}</label>
                    <input type="text" name="email" class="email form-control" id="email">
                 </div>
                 <div class="form-group">
                    <label for="company">{{ __('site.Company') }}</label>
                    <input type="text" name="company" class="company form-control" id="company">
                 </div>
                 <div class="form-group">
                    <label for="mobile-no">{{ __('site.Mobile') }}</label>
                    <input type="text" name="mobile_no" class="mobile-no form-control" id="mobile-no">
                 </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('site.Close') }}</button>
                  <button type="button" class="form-submit-btn btn btn-primary"  data-url="{{ route('save-enquiry') }}">{{ __('site.Send Enquiry') }}</button>
                </div>
              </div>
            </div>
          </div>
        
        
</form>



  {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button> --}}
@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $('.system_type').on('click', function(){
        $('.system_type').removeClass('active');
        $(this).addClass('active');
        var system_type = $(this).data('id');
        var system_type_name= $(this).data('name');
        $('#selected_system_type').val(system_type);
        if(system_type_name == 'HD Analogue system'){
           $(".Professional").hide(); 
        }else{
            $(".Professional").show(); 
        }

    });  



    $('.camera_quantity').on('change', function(){
        var camera_quantity = $(this).val();

        if(camera_quantity > 0){
            $('.recorder_btn').show();
        }else{
            $('.recorder_btn').hide();
        }
    });

    $('.standard').on('click', function(){
        $('.standard').removeClass('active');
        $(this).addClass('active');
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
                    console.log('helo');
                    $('#recorder_attribute_div').empty();
                    $('#recorder_attribute_div').append(data.html_recorder);

                }
                $('input[name="camera_count"]').val(data.count);
                $('input[name="recorder_count"]').val(data.count);

            },
            
        });



    });   

    $(document).on('change', '.attribute',function(){
        var attribute_value_arr = [];
        var cam_attribute_value_arr  = [];
        var rec_attribute_value_arr = [];
        var ele = $(this);
        
        
        var system_type = $(this).data('system_type');
        var product_type = $(this).data('product_type');
        var count = $('input[name="'+ product_type +'_count"]').val();
      
        //console.log($(this).data('product_type'));


        $('.attribute', '.'+product_type+'_div_'+ count).each(function(){
            
            if($(this).val() != ''){
           
                if($(ele).data('product_type') == 'camera'){
                 
                    cam_attribute_value_arr.push($(this).val());
                }else{
                    rec_attribute_value_arr.push($(this).val());
                }
            }
            
        
        });
        
        if($(ele).data('product_type') == 'camera'){
            var attribute_val = cam_attribute_value_arr.join(','); 
             $('input[name="selected_'+ product_type +'_attributes_'+ count +'"]').val(attribute_val);
        }else if($(ele).data('product_type') == 'recorder'){
            var attribute_val = rec_attribute_value_arr.join(',');
            $('input[name="selected_'+ product_type +'_attributes_'+ count +'"]').val(attribute_val);
        }

        //console.log(attribute_val);
      
        //console.log( $('input[name="selected_'+ product_type +'_attributes_'+ count +'"]').val());
        

        
        

        $.ajax({
            method: 'post',
            url: '{{ route('update-attributes') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'attribute_value' : attribute_val,
                'system_type': system_type,
                'product_type': product_type,
                'count': count,
            },
            success: function(data){
                if(data.success == true && data.html != ''){
                    
                    if(data.product_type == 'camera'){

                        $('.'+product_type+'_div_'+count).empty();
                        $('.'+product_type+'_div_'+count).append(data.html);
                    }else if(data.product_type == 'recorder'){
                        $('.'+product_type+'_div_'+count).empty();
                        $('.'+product_type+'_div_'+count).append(data.html);
                    }
                }
            }
        });

    });


    $(document).on('click','.next_type', function(){
        var product_type = $(this).data('product_type');

        var old_count =  $('input[name="'+ product_type +'_count"]').val();
        //console.log(old_count);
        var standard = $('#selected_system_type').val();
        var system_type = $('#selected_system_type').val();


        $.ajax({
            method: 'post',
            url: '{{ route('get-next-product') }}',
            data: {
                'product_type': product_type,
                'count': old_count,
                'system_type': system_type,
                'standard': standard,
                '_token': '{{ csrf_token() }}',
            },
            success:function(data){
                if(data.success == true){
                    $('.'+product_type+'_'+ old_count).after(data.html);
                    $('.'+product_type+'_'+ old_count).hide();
                    $('input[name="'+ product_type +'_count"]').val(data.count);
                }
            },
        });


    });

    $('.form-submit-btn').on('click', function(){
        var url = $(this).data('url');
        var formData = new FormData($('#product-enquiry')[0]);
        console.log(formData);
        jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });


        $.ajax({
            method: 'post',
            url: url,
            data:  formData,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false,
            success: function(data){
                if(data.success){
                    swal({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                        button: "OK",
                    }).then((value) => {
                        location.reload();
                    });
                    
                }else{
                    swal({
                        title: "Error",
                        text: data.message,
                        icon: "error",
                        button: "OK",
                    });
                }
            }
        });
    });



    $('.summary').on('click', function(){
        var url = $(this).data('url');
        var formData = new FormData($('#product-enquiry')[0]);
        console.log(formData);

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });


        $.ajax({
            method: 'post',
            url: url,
            data:  formData,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false,
            success: function(data){
                if(data.success){
                   if(data.html != ''){
                    var mywindow = window.open('', 'my div', 'height=400,width=600');
                    mywindow.document.write('<html><head><title>my div</title>');
                    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
                    mywindow.document.write('</head><body >');
                    mywindow.document.write(data.html);
                    mywindow.document.write('</body></html>');

                    mywindow.print();
                   // mywindow.close();

                    return true;
                   }
                    
                }else{
                  
                }
            }
        });
    });





</script>
@endsection