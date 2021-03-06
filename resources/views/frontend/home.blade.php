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
                                <h3>{{ translate('System Type') }}</h3>
                                <div class="col-kemey col-kemey-two">
                                    <div class="row d-flex align-items-center">
                                        <input type="hidden" id="selected_system_type" name="selected_system_type" value="">
                                        @foreach ($system_types as $system_type)
                                            <div class="col-xl-6 col-md-6">
                                                <button type="button" class="system_type"
                                                    data-name="{{ $system_type->name }}"
                                                    data-id="{{ $system_type->id }}">{{ translate($system_type->name) }}</button>
                                            </div>
                                        @endforeach

                                        <div class="col-xl-6 col-md-12 pl-xl-3">
                                            <p class="ml-xl-5 pl-xl-5">
                                                {{-- Lorem Ipsum is simply dummy text of the printing and typesetting industry. --}}
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
                            <button type="button" class="save" data-url="{{ route('save-enquiry') }}" data-toggle="modal"
                                data-target="#exampleModal">{{ translate('Send Enquiry') }}</button>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <button type="button" class="summary"
                                data-url="{{ route('print.enquiries') }}">{{ translate('Summary') }}</button>
                        </div>
                        <div class="col-xl-3 col-md-4">
                            <button type="reset" value="reset" class="btnreset"
                                onclick="window.location.reload()">{{ translate('Reset All Values') }}</button>
                        </div>
                        {{-- <div class="col-xl-3 col-md-4">
                            <button>Kamey / Cameras</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ translate('Customer Details') }}</h5>
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
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ translate('Close') }}</button>
                        <button type="button" class="form-submit-btn btn btn-primary"
                            data-url="{{ route('save-enquiry') }}">{{ translate('Send Enquiry') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="available_series" value="" id="available_series">
        <input type="hidden" name="final_series" id="final_series" value="">
    </form>
    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button> --}}
@endsection

@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var series_type = 'unimportant';
        var series_value = 0;
        var set_series = 'unimportant';
        var first_selected_product_type = '';
        $(document).ready(function() {
            $('.system_type:first-child').click();
        });


        $('.system_type').on('click', function() {

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
                success: function(data) {
                    $('.selected_standard').empty();
                    if (data.standard_attribute != '') {
                        $('.selected_standard').append(data.standard_attribute);
                        $('.selected_standard').show();
                    }
                    // $('.kemey-cameras-sec .container').empty();
                    // $('.hidden').empty();
                    // $.each(data.html, function(index, value) {
                    //     $('.kemey-cameras-sec .container').append(value);
                    //     $('.hidden').append('<input type="hidden" name="' + index +
                    //         '_count" value="' + data.count +
                    //         '"><input type="hidden" name="total_qty[' + index +
                    //         ']" value="0">');
                    // });
                }
            });
        });




        $(document).on('change', '.qty, .recorder_cal_col', function() {

            var type = $(this).parents('.col-kemey').data('type');
            var qty = calcQty(type);
            $(this).parents('.col-kemey').find('.totalQty span').text(qty);
        });
        // $(document).on('change', '.camera_1 .camera_cal_col', function() {
        //     series_type = $(this).val();
        // });

        $(document).on('change', '.series_val', function() {

            if (series_type == "unimportant") {
                series_type = $(this).find('option:selected').text();
            }
            setSeries();
            // if($(this).hasClass('camera_cal_col')){
            //     console.log('camera');
            //         $('.series_val').trigger('change');
            // }else{
            //     console.log('rec');
            //     $('.series_val').trigger('change');
            // }
        });

        function setSeries() {
            var i = 0;
            $('.kemey-cameras-sec').find('.col-kemey').each(function() {
                //  console.log(i);
                i++;
                // console.log(series_value);
                $(this).find(".series_val option").filter(function() {
                    //console.log($(this));
                    if (this.text == series_type) {
                        series_value = this.value;
                        return true;
                    }
                }).attr('selected', true);
                $(this).find('.series_val').val(series_value);


            });
        }


        $(document).on('click', '.standard', function() {
            $('.standard').removeClass('active');
            $(this).addClass('active');
            $('#selected_standard').val($(this).data('id'));

            var standard_id = $(this).data('id');
            var system_type_id = $('#selected_system_type').val();

            $.ajax({
                method: 'post',
                url: '{{ route('front-get-attributes') }}',
                data: {
                    'system_type_id': system_type_id,
                    'standard_id': standard_id,
                    '_token': $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(data) {

                    $('.kemey-cameras-sec .container').empty();
                    $('.hidden').empty();
                    $.each(data.html, function(index, value) {
                        $('.kemey-cameras-sec .container').append(value);
                        $('.hidden').append('<input type="hidden" name="' + index +
                            '_count" value="' + data.count +
                            '"><input type="hidden" name="total_qty[' + index +
                            ']" value="0">');
                    });
                }
            });

        });

        $(document).on('change', '.attribute', function() {
            // $('.camera_cal_col').val(series_type);
            setSeries();
            //$('.series_val').val(series_type);
            var attribute_value_arr = [];
            var second_attribute_value_arr = [];
            var ele = $(this);
            var standard = $('#selected_standard').val();
            var system_type = $(this).data('system_type');
            var product_type = $(this).data('product_type');
            var available_series = $('#available_series').val();

            if (first_selected_product_type == '') {
                first_selected_product_type = product_type;
            }

            if (product_type == 'camera') {
                second_product_type = 'recorder';
            } else {
                second_product_type = 'camera';
            }

            
            // else {
            //     available_series = '';
            // }

            var count = $('input[name="' + product_type + '_count"]').val();

            var second_count = $('input[name="' + second_product_type + '_count"]').val();

            var selected_attributes = [];
            var second_selected_attributes = [];

            //$('.attribute', '.' + product_type + '_div_' + count).each(function() {
            $('.' + product_type + '_div_' + count + ' .attribute').each(function() {
                if ($(this).val() != '') {
                    selected_attributes[$(this).data('attribute')] = $(this).val();
                    attribute_value_arr.push($(this).val());
                }
            });

            if (first_selected_product_type != product_type) {
                available_series = available_series;
                $('.' + second_product_type + '_div_' + second_count + ' .attribute').each(function() {
                    if ($(this).val() != '') {
                        second_selected_attributes[$(this).data('attribute')] = $(this).val();
                        second_attribute_value_arr.push($(this).val());
                    }
                });
            } 


            console.log(attribute_value_arr, second_attribute_value_arr);

            var attribute_val = attribute_value_arr.join(',');
            var second_attribute_val = second_attribute_value_arr.join(',');

            $.ajax({
                method: 'post',
                url: '{{ route('update-attributes') }}',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr("content"),
                    'attribute_value': attribute_val,
                    'system_type': system_type,
                    'standard': standard,
                    'product_type': product_type,
                    'count': count,
                    'second_count': second_count,
                    'selected_attributes': selected_attributes,
                    'available_series': available_series,
                    'first_selected_product_type': first_selected_product_type,
                    'second_attribute_value': second_attribute_val,
                    'second_selected_attributes': second_selected_attributes,
                },
                success: function(data) {
                    if (data.success == true && data.html != '') {
                        console.log(data.pro_series);
                        $('.' + product_type + '_div_' + count).empty();
                        $('.' + product_type + '_div_' + count).append(data.html);
                        available_series = data.available_series;
                        $('#available_series').val(data.available_series);
                        if (first_selected_product_type == product_type) {
                            if (data.configuration_status != '') {
                                swal('Sorry!', data.configuration_status, 'warning');
                            }
                        }
                        console.log();
                        // else{
                        if (data.second_html != '' && available_series != '') {
                            $('.' + second_product_type + '_div_' + second_count).empty();
                            $('.' + second_product_type + '_div_' + second_count).append(data
                                .second_html);
                        }

                        $('#final_series').val(data.pro_series);
                       
                        
                        
                        //}
                        // set_series = data.pro_series;

                        //setSeries();
                        // $('.series_val option').map(function() {
                        //     let series = $(this).text().toUpperCase();
                        //     if (series == data.pro_series) return this;
                        // }).attr('selected', 'selected');
                        //}
                        //$('.' + product_type + '_' + count).find('.series_val').trigger('change');
                    }
                },
            });

        });

        function getOtherProduct() {

        }

        $(document).on('click', '.next_type', function() {
            var product_type = $(this).data('product_type');
            var this_product_qty = $(this).parentsUntil('.section_' + product_type).siblings('.align-items-center')
                .find('.qty').val();
            if (this_product_qty == '' || this_product_qty <= 0) {
                swal({
                    title: "Error",
                    text: '{{ translate('Please Enter Quantity for the products.') }}',
                    icon: "error",
                    button: "OK",
                });
                return;
            }
            let attr_count = 0;
            let unselected_attr_count = 0;
            $(this).parentsUntil('.section_' + product_type).find('.attribute').each(function() {
                attr_count++;
                if ($(this).find('option:selected').val() == 'unimportant') {
                    unselected_attr_count++;
                }
            });
            if (attr_count == unselected_attr_count) {
                swal({
                    title: "Error",
                    text: 'Please select at-least one attribute.',
                    icon: "error",
                    button: "OK",
                });
                return;
            }



            nextProduct(product_type);
        });

        $(document).on('click', '.reset', function() {

            var btn = $(this);
            var target = $(btn).data('target');
            var type = $('.' + target).data('type');
            var count = $('.' + target).data('count');
            // console.log($('.'+ target).data('type'));

            var current_qty = $('.' + type + '_' + count).find('.qty').val();
            $('.' + type + '_' + count).find('.qty').val('');

            // console.log($('.'+ target).find('.reset_all_values').prop("selectedIndex",0));
            // $('.'+ target).find('.reset_all_values').prop("selectedIndex",0);
            $('.' + target).find('.reset_all_values').each(function() {
                // console.log($(this).children('option:selected').val());
                $(this).children('option:selected').removeAttr('selected');
                $(this).prop("selectedIndex", 0);
                // console.log($(this).children('option:selected').val());
                $(this).children('option:first-child').attr('selected', 'selected');

            });

            $('.' + target).find('.attribute').trigger('change');
            // if(current_qty == '' || current_qty == undefined){
            //     current_qty = 0;
            // }

            var total_qty = calcQty(type);

            var final_qty = total_qty;

            // console.log($('.'+ target).find('.total_qty'));
            $('.' + type + '_' + count).find('.total_qty').val(final_qty);

            $('.' + type + '_' + count + ' .totalQty span').text(final_qty);
            // if(final_qty <= 0){
            //     $('.' + type + '_' + count + ' .totalQty').hide();
            // }
            if (type == first_selected_product_type) {
                $('#available_series').val('');
                first_selected_product_type = '';
            }


        });

        function nextProduct(product_type) {
            var old_count = $('input[name="' + product_type + '_count"]').val();
            var system_type = $('#selected_system_type').val();
            var standard = $('#selected_standard').val();
            var available_series = $('#available_series').val();



            $.ajax({
                method: 'post',
                url: '{{ route('get-next-product') }}',
                data: {
                    'product_type': product_type,
                    'count': old_count,
                    'system_type': system_type,
                    'standard': standard,
                    '_token': $('meta[name="csrf-token"]').attr("content"),
                    'available_series': available_series,
                    'first_selected_product_type': first_selected_product_type,
                },
                success: function(data) {
                    if (data.success == true) {
                        if (old_count == 0) {
                            $('.kemey-cameras-sec .container').append(data.html);
                        } else {
                            $('.' + product_type + '_' + old_count).after(data.html);
                            $('.' + product_type + '_' + old_count).hide();
                        }
                        $('input[name="' + product_type + '_count"]').val(data.count);
                        var qty = calcQty(product_type);
                        $('.' + product_type + '_' + data.count + ' .totalQty span').text(qty);
                        $('.' + product_type + '_' + data.count).show();
                        //if (product_type == 'camera') {
                        //$('.' + product_type + '_' + data.count).find('.camera_cal_col').val(series_type);
                        // $('.series_val option').map(function() {
                        //     if ($(this).text() == series_type) return this;
                        // }).attr('selected', 'selected');
                        //}
                        //$('.' + product_type + '_' + old_count).find('.series_val.attribute').trigger('change');
                    }
                },
            });
        }

        function calcQty(type) {
            var totalQty = 0;
            var qty = 0;
            $('.section_' + type).each(function(index, item) {
                qty = 0;
                if (type == 'recorder') {
                    if ($(this).find('.' + type + '_cal_col').val() == 'unimportant' && $(this).find('.qty')
                        .val() == '') {
                        qty = 0;
                    } else if ($(this).find('.' + type + '_cal_col').val() == 'unimportant') {
                        qty = parseInt($(this).find('.qty').val());
                    } else if ($(this).find('.qty').val() == '') {
                        qty = parseInt($(this).find('.' + type + '_cal_col option:selected').text());
                    } else {
                        qty = parseInt($(this).find('.qty').val()) * parseInt($(this).find('.' + type +
                            '_cal_col option:selected').text());
                    }
                } else {
                    if ($(this).find('.qty').val() == '') {
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

        $('.form-submit-btn').on('click', function() {
            var url = $(this).data('url');
            var formData = new FormData($('#product-enquiry')[0]);

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });
            $.ajax({
                method: 'post',
                url: url,
                data: formData,
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false,
                success: function(data) {
                    if (data.success) {
                        swal({
                            title: "Success",
                            text: data.message,
                            icon: "success",
                            button: "OK",
                        }).then((value) => {
                            location.reload();
                        });

                    } else {
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

        $('.summary').on('click', function() {
            var url = $(this).data('url');
            var final_series = $('#final_series').val();
            var formData = new FormData($('#product-enquiry')[0]);
            formData.append('first_selected_product_type', first_selected_product_type);
            //formData.append('final_series', final_series);
            // let attr_count =0;
            // let unselected_attr_count = 0;
            //     $('.attribute').each(function(){
            //         let attr_count =0;
            //     let unselected_attr_count = 0;
            //         if($(this).data('product_type') == 'recorder'){

            //         }

            //         attr_count++;

            //         if($(this).find('option:selected').val() == 'unimportant'){
            //             unselected_attr_count++;
            //         }
            //     });
            //    if(attr_count == unselected_attr_count){
            //     swal({
            //                     title: "Error",
            //                     text: 'Please select atleast one attribute from dropdowns.',
            //                     icon: "error",
            //                     button: "OK",
            //                 });
            //        return;
            //    }

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            });
            $.ajax({
                method: 'post',
                url: url,
                data: formData,
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false,
                success: function(data) {
                    if (data.success) {
                        // console.log(data.priority_product_series);
                        // if (data.priority_product_series != '') {
                        //     set_series = data.priority_product_series;
                        //     series_type = set_series;
                        //     setSeries();
                        //     $('.series_val.attribute').each(function() {
                        //         console.log('changed');
                        //         $(this).trigger('change');
                        //     });
                        // }

                        if (data.html != '') {
                            var mywindow = window.open('', 'Summary', 'height=400,width=600');
                            mywindow.document.write('<html><head><title>Summary</title>');
                            /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
                            mywindow.document.write('</head><body >');
                            mywindow.document.write(data.html);
                            mywindow.document.write('</body></html>');

                            mywindow.print();
                            // mywindow.close();

                            return true;
                        }


                    } else {
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
