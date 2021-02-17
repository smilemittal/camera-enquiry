@extends('frontend.layouts.app')
@section('styles')
    <style>
        #product-enquiry .active {
            background: #007ecb !important;
        }
    </style>
@endsection

@section('content')
<form method="post" action="" id="product-enquiry" enctype="multipart/form-data">
        <div class="form-sec">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-radius-box">
                            <div class="heading-btns">
                            <h3>{{translate('System Type') }}</h3>
                                <div class="col-kemey col-kemey-two">
                                    <div class="row d-flex align-items-center">
                                        <input type="hidden" id="selected_system_type" name="selected_system_type" value="">
                                        @foreach($system_types as $system_type)
                                            <div class="col-xl-6 col-md-6">
                                                <button type="button" class="system_type" data-name="{{ $system_type->name }}" data-id="{{ $system_type->id }}">{{ translate($system_type->name) }}</button>
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
                        <h3>{{ translate('Standard') }}</h3>
                            <div class="col-kemey col-kemey-two">
                                <input type="hidden" id="selected_standard" name="selected_standard" value="">
                                <div class="row d-flex align-items-center selected_standard">

                                        {{-- <div class="col-xl-3 col-md-4">
                                        <button type="button" class="standard {{ $standard->name }}" data-name="{{ $standard->name }}" data-id="{{ $standard->id }}">{{ $standard->name }}</button>
                                        </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden"></div>
        <div class="kemey-cameras-sec">
            <div class="container">
            </div>
        </div>

        <div class="three-btn-sec">
            <div class="container">
                <div class="col-kemey">
                    <div class="row d-flex align-items-center">
                        <div class="col-xl-3 col-md-4">
                        <button type="button" class="save" data-url="{{ route('save-enquiry') }}" data-toggle="modal" data-target="#exampleModal">{{ translate('Send Enquiry') }}</button>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <button type="button" class="summary" data-url="{{ route('print.enquiries') }}">{{translate('Summary')}}</button>
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
                  <h5 class="modal-title" id="exampleModalLabel">{{translate('Customer Details')}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                 <div class="form-group">
                 <label for="first-name">{{ translate('First Name') }}</label>
                    <input type="text" name="first_name" class="first-name form-control" id="first-name">
                 </div>
                 <div class="form-group">
                    <label for="last-name">{{ translate('Last Name') }}</label>
                    <input type="text" name="last_name" class="last-name form-control" id="last-name">
                 </div>
                 <div class="form-group">
                    <label for="email">{{ translate('Email') }}</label>
                    <input type="text" name="email" class="email form-control" id="email">
                 </div>
                 <div class="form-group">
                    <label for="company">{{ translate('Company') }}</label>
                    <input type="text" name="company" class="company form-control" id="company">
                 </div>
                 <div class="form-group">
                    <label for="mobile-no">{{ translate('Mobile') }}</label>
                    <input type="text" name="mobile_no" class="mobile-no form-control" id="mobile-no">
                 </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('Close') }}</button>
                  <button type="button" class="form-submit-btn btn btn-primary"  data-url="{{ route('save-enquiry') }}">{{ translate('Send Enquiry') }}</button>
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
    var series_type = 'unimportant';
    $(document).ready(function(){
        $('.system_type:first-child').click();
    });
    $('.system_type').on('click', function(){
        var system_type_id = $(this).data('id');
        $('.system_type').removeClass('active');
        $(this).addClass('active');
        $('#selected_system_type').val(system_type_id);
        $.ajax({
            method: 'post',
            url: '{{ route('get-standard') }}',
            data: {
                'system_type_id': system_type_id,
                '_token': $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(data){
                $('.selected_standard').empty();
                if(data.standard_attribute != ''){
                    $('.selected_standard').append(data.standard_attribute);
                    $('.selected_standard').show();
                }
                $('.kemey-cameras-sec .container').empty();
                $('.hidden').empty();
                $.each(data.html, function( index, value ) {
                    $('.kemey-cameras-sec .container').append(value);
                    $('.hidden').append('<input type="hidden" name="'+index+'_count" value="'+data.count+'"><input type="hidden" name="total_qty['+index+']" value="0">');
                });
            }
        });
    });

    $(document).on('change', '.qty, .recorder_cal_col', function(){
        var type = $(this).parents('.col-kemey').data('type');
        var qty = calcQty(type);
        $(this).parents('.col-kemey').find('.totalQty span').text(qty);
    });
    $(document).on('change', '.camera_1 .camera_cal_col', function(){
        series_type = $(this).val();
    });

    $(document).on('click', '.standard', function(){
        $('.standard').removeClass('active');
        $(this).addClass('active');
        $('#selected_standard').val($(this).data('id'));
    });

    $(document).on('change', '.attribute',function(){
        $('.camera_cal_col').val(series_type);
        var attribute_value_arr = [];
        var ele = $(this);

        var system_type = $(this).data('system_type');
        var product_type = $(this).data('product_type');
        var count = $('input[name="'+ product_type +'_count"]').val();
        var selected_attributes = [];

        $('.attribute', '.'+product_type+'_div_'+ count).each(function(){

            if($(this).val() != ''){
                selected_attributes[$(this).data('attribute')] = $(this).val();
                attribute_value_arr.push($(this).val());
            }
        });

        var attribute_val = attribute_value_arr.join(',');

        $.ajax({
            method: 'post',
            url: '{{ route('update-attributes') }}',
            data: {
                '_token': $('meta[name="csrf-token"]').attr("content"),
                'attribute_value' : attribute_val,
                'system_type': system_type,
                'product_type': product_type,
                'count': count,
                'selected_attributes': selected_attributes
            },
            success: function(data){
                if(data.success == true && data.html != ''){
                    $('.'+product_type+'_div_'+count).empty();
                    $('.'+product_type+'_div_'+count).append(data.html);
                }
            }
        });

    });
    $(document).on('click','.next_type', function(){
        var product_type = $(this).data('product_type');
        nextProduct(product_type);
    });
    function nextProduct(product_type){
        var old_count =  $('input[name="'+ product_type +'_count"]').val();
        var system_type = $('#selected_system_type').val();
        var standard = $('#selected_standard').val();
        $.ajax({
            method: 'post',
            url: '{{ route('get-next-product') }}',
            data: {
                'product_type': product_type,
                'count': old_count,
                'system_type': system_type,
                'standard': standard,
                '_token': $('meta[name="csrf-token"]').attr("content"),
            },
            success:function(data){
                if(data.success == true){
                    if(old_count == 0) {
                        $('.kemey-cameras-sec .container').append(data.html);
                    } else {
                        $('.'+product_type+'_'+ old_count).after(data.html);
                        $('.'+product_type+'_'+ old_count).hide();
                    }
                    $('input[name="'+ product_type +'_count"]').val(data.count);
                    var qty = calcQty(product_type);
                    $('.'+product_type+'_'+ data.count+ ' .totalQty span').text(qty);
                    $('.'+product_type+'_'+ data.count).show();
                    if(product_type == 'camera') {
                        $('.'+product_type+'_'+data.count).find('.camera_cal_col').val(series_type);
                    }
                }
            },
        });
    }

    function calcQty(type) {
        var totalQty = 0;
        var qty = 0;
        $('.section_'+type).each(function(index, item){
            qty = 0;
            if(type == 'recorder') {
                if($(this).find('.'+ type + '_cal_col').val() == 'unimportant' && $(this).find('.qty').val() == '') {
                    qty = 0;
                } else if($(this).find('.'+ type + '_cal_col').val() == 'unimportant') {
                    qty = parseInt($(this).find('.qty').val());
                } else if($(this).find('.qty').val() == '') {
                    qty = parseInt($(this).find('.'+ type + '_cal_col option:selected' ).text());
                } else {
                    qty = parseInt($(this).find('.qty').val()) * parseInt($(this).find('.'+ type + '_cal_col option:selected' ).text());
                }
            } else {
                if($(this).find('.qty').val() == '') {
                    qty = 0;
                } else {
                    qty = parseInt($(this).find('.qty').val());
                }
            }
            $(this).find('.total_qty').val(qty);
            totalQty += qty;
        });

        return totalQty;
    }

    $('.form-submit-btn').on('click', function(){
        var url = $(this).data('url');
        var formData = new FormData($('#product-enquiry')[0]);
        console.log(formData);
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
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
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
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
</script>
@endsection
