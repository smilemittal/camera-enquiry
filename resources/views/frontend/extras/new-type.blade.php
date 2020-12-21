@if($product_type == 'camera')
<div class="col-kemey {{ 'camera_'.$i }}">
    <div class="row d-flex align-items-center">
        <div class="col-xl-3 col-md-6">
        <a class="btn" data-toggle="collapse" href="#{{ 'multiCollapseExample'.$product_type.$i  }}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">kamery / Cameras</a>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="kamaroty">
                <input type="text" name="quantity[{{ $product_type }}][{{ $i }}]" placeholder="Qty"/>
            </div>
        </div>
        <div class="col-md-12 col-xl-7 pl-lg-3">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
        </div>
    </div>
    <div class="collapse multi-collapse" id="{{ 'multiCollapseExample'.$product_type.$i }}">
        <div class="card card-body">
            <input type="hidden" name="{{ 'selected_'.$product_type.'_attributes_'.$i}}">
        
            <div id="camera_attribute_div">
               
                    @if(!empty($attribute_html))
                        {!! $attribute_html !!}
                    @endif
               

            </div>

            <p class="earch">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

            <div class="col-kemey kemey-boxbtn">
                <div class="row d-flex align-items-center">
                    <div class="col-xl-3 col-md-6">
                        <button type="button" class="next_type" data-product_type="camera">Kamey / Next Type of Cameras</button>
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
<div class="col-kemey {{ 'recorder_'.$i }} {{ $product_type.'_btn' }}" style="display:none;" >
    <div class="row d-flex align-items-center">
        <div class="col-xl-3 col-md-6">
            <a class="btn" data-toggle="collapse" href="#{{ 'multiCollapseExample'.$product_type.$i }}" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">kamery / Recorders</a>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="kamaroty">
                <input type="text" name="quantity[{{ $product_type }}][{{ $i }}]" placeholder="Qty"/>
            </div>
        </div>
        <div class="col-md-12 col-xl-7 pl-lg-3">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
        </div>
    </div>
    <div class="collapse multi-collapse" id="{{ 'multiCollapseExample'.$product_type.$i }}">
        <div class="card card-body">
            <input type="hidden" name="{{ 'selected_'.$product_type.'_attributes_'.$i}}">
            <div id="recorder_attribute_div">
                @if(!empty($attribute_html))
                {!! $attribute_html !!}
                @endif
            </div>

            <p class="earch">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>

            <div class="col-kemey kemey-boxbtn">
                <div class="row d-flex align-items-center">
                    <div class="col-xl-3 col-md-6">
                        <button type="button" class="next_type" data-product_type="recorder">Kamey / Next Type of Recorder</button>
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

