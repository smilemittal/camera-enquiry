<div class="col-kemey section_{{$type->slug}} {{ $type->slug.'_'.$i }}">
    <div class="row d-flex align-items-center">
        <div class="col-xl-3 col-md-6">
        <a class="btn" data-toggle="collapse" href="#{{ 'multiCollapseExample'.$type->slug.$i  }}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">{{ translate($type->name) }}</a>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="kamaroty">
                <input type="text" class="qty" name="quantity[{{ $type->slug }}][{{ $i }}]" placeholder="Qty"/>
            </div>
        </div>
        <div class="col-md-12 col-xl-5 pl-lg-3">
            <p>{{translate($type->name.' panel description')}}</p>
            <div class="totalQty">
                <span class=""></span>
            </div>
        </div>
        {{-- <div class="col-xl-2 col-md-6">

        </div> --}}
    </div>
    <div class="collapse multi-collapse" id="{{ 'multiCollapseExample'.$type->slug.$i }}">
        <div class="card card-body">
            <input type="hidden" name="{{ 'selected_'.$type->slug.'_attributes_'.$i}}">

            <div id="{{$type->slug}}_attribute_div">
                    @if(!empty($attribute_html))
                        {!! $attribute_html !!}
                    @endif
            </div>

            <p class="earch">{{translate($type->name . ' panel description')}}</p>

            <div class="col-kemey kemey-boxbtn">
                <div class="row d-flex align-items-center">
                    <div class="col-xl-3 col-md-6">
                        <button type="button" class="next_type" data-product_type="{{$type->slug}}">{{ translate('Next Type of '.$type->name) }}</button>
                    </div>
                    {{-- <div class="col-xl-3 col-md-6">
                        <button>Kamey / Cameras</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
