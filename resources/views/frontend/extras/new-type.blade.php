@if($product_type == 'camera')
<div class="col-kemey section_{{$product_type}} {{ 'camera_'.$i }}">
    <div class="row d-flex align-items-center">
        <div class="col-xl-3 col-md-6">
        <a class="btn" data-toggle="collapse" href="#{{ 'multiCollapseExample'.$product_type.$i  }}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">{{ translate('Cameras') }}</a>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="kamaroty">
                <input type="text" class="qty" name="quantity[{{ $product_type }}][{{ $i }}]" placeholder="Qty"/>
            </div>
        </div>
        <div class="col-md-12 col-xl-5 pl-lg-3">
            <p>{{translate('Camera panel description')}}</p>
            <div class="totalQty">
                <span class=""></span>
            </div>
        </div>
        {{-- <div class="col-xl-2 col-md-6">
           
        </div> --}}
    </div>
    <div class="collapse multi-collapse" id="{{ 'multiCollapseExample'.$product_type.$i }}">
        <div class="card card-body">
            <input type="hidden" name="{{ 'selected_'.$product_type.'_attributes_'.$i}}">

            <div id="camera_attribute_div">
                    @if(!empty($attribute_html))
                        {!! $attribute_html !!}
                    @endif
            </div>

            <p class="earch">{{translate('Camera panel description')}}</p>

            <div class="col-kemey kemey-boxbtn">
                <div class="row d-flex align-items-center">
                    <div class="col-xl-3 col-md-6">
                        <button type="button" class="next_type" data-product_type="camera">{{ translate('Next Type of Cameras') }}</button>
                    </div>
                    {{-- <div class="col-xl-3 col-md-6">
                        <button>Kamey / Cameras</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endif



@if($product_type == 'recorder')
<div class="col-kemey section_{{$product_type}} {{ 'recorder_'.$i }} {{ $product_type.'_btn' }}" style="display:none;" >
    <div class="row d-flex align-items-center">
        <div class="col-xl-3 col-md-6">
            <a class="btn" data-toggle="collapse" href="#{{ 'multiCollapseExample'.$product_type.$i }}" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">{{ translate('Recorder') }}</a>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="kamaroty">
                <input type="text" class="qty" name="quantity[{{ $product_type }}][{{ $i }}]" placeholder="Qty"/>
            </div>
        </div>
        <div class="col-md-12 col-xl-7 pl-lg-3">
            <p>{{translate('Recorder panel description')}}</p>
            <div class="totalQty">
                <span class=""></span>
            </div>
        </div>
        {{-- <div class="col-xl-2 col-md-6">
           
        </div> --}}
    </div>
    <div class="collapse multi-collapse" id="{{ 'multiCollapseExample'.$product_type.$i }}">
        <div class="card card-body">
            <input type="hidden" name="{{ 'selected_'.$product_type.'_attributes_'.$i}}">
            <div id="recorder_attribute_div">
                @if(!empty($attribute_html))
                {!! $attribute_html !!}
                @endif
            </div>

            <p class="earch">{{translate('Recorder panel description')}}</p>

            <div class="col-kemey kemey-boxbtn">
                <div class="row d-flex align-items-center">
                    <div class="col-xl-3 col-md-6">
                        <button type="button" class="next_type" data-product_type="recorder">{{ translate('Next Type of Recorder') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

