
@if(!empty($attribute_camera))
    <div class="row {{ 'camera_div_'.$i }}">
        @foreach($attribute_camera as $attribute)

            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                <label>{{ $attribute->name }}</label>
                <select name="products[camera][{{$i}}][{{ $attribute->id }}]" id="camera_attributes" class="attribute" data-count="{{ $i }}" data-product_type="camera" data-system_type="{{ $system_type }}" data-attribute="{{$attribute->id}}">
                    <option value="unimportant">Unimportant</option>
                        @if(!empty($attribute->attribute_values))
                            @foreach($attribute->attribute_values as $attribute_value)
                                <option value="{{ $attribute_value->id }}">{{ translate($attribute_value->value)}}</option>
                            @endforeach
                        @endif
                    </select>
                    <p>{!! htmlspecialchars($attribute->description) !!}</p>
                </div>
            </div>
        @endforeach
    </div>
@endif



@if(!empty($attribute_recorder))
    <div class="row {{ 'recorder_div_'.$i }}">
        @foreach($attribute_recorder as $attribute)

            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                <label>{{ $attribute->name }}</label>
                    <select name="products[recorder][{{$i}}][{{ $attribute->id }}]" id="recorder_attributes" class="attribute" data-count="{{ $i }}" data-product_type="recorder" data-system_type="{{ $system_type }}" data-attribute="{{$attribute->id}}">
                        <option value="unimportant">Unimportant</option>
                        @if(!empty($attribute->attribute_values))
                            @foreach($attribute->attribute_values as $attribute_value)
                                <option value="{{ $attribute_value->id }}">{{ transalte($attribute_value->value) }}</option>
                            @endforeach
                        @endif
                    </select>
                    <p>{!! htmlspecialchars($attribute->description) !!}</p>
                </div>
            </div>
        @endforeach
    </div>
@endif




@if(!empty($all_attributes))
{{-- <div class="row {{ $product_type.'_div_'.$i }} update"> --}}

    @foreach($all_attributes as $attribute)

        <div class="col-lg-3 col-md-6">
            <div class="form-group">
                <label>{{ $attribute->name }}</label>
                <select name="products[{{ $product_type }}][{{$i}}][{{ $attribute->id }}]" id="{{ $product_type.'_attributes' }}" class="attribute"  data-count="{{ $i }}" data-product_type="{{ $product_type }}" data-system_type="{{ $system_type }}" data-attribute="{{$attribute->id}}">
                    <option value="unimportant">Unimportant</option>
                    @if(!empty($attribute->attribute_values))
                        @foreach($attribute->attribute_values as $attribute_value)
                            @if($attribute_value->id == $selected_attributes[$attribute->id] || (!empty($attributes[$attribute->id]) && in_array($attribute_value->id, $attributes[$attribute->id])))
                                <option value="{{ $attribute_value->id }}" {{ $attribute_value->id == $selected_attributes[$attribute->id] ? 'selected' : '' }}>{{ translate($attribute_value->value)}}</option>
                            @endif
                        @endforeach
                    @endif

                </select>
                <p>{!! htmlspecialchars($attribute->description) !!}</p>
            </div>
        </div>
    @endforeach
{{-- </div> --}}
@endif



@if(!empty($attributes_new_product))
<div class="row {{ $product_type.'_div_'.$i }}">
    @foreach($attributes_new_product as $attribute)

        <div class="col-lg-3 col-md-6">
            <div class="form-group">
            <label>{{ $attribute->name }}</label>
            <select name="products[{{ $product_type }}][{{$i}}][{{ $attribute->id }}]" id="{{ $product_type.'_attributes' }}" class="attribute" data-product_type="{{ $product_type }}" data-system_type="{{ $system_type }}" data-attribute="{{$attribute->id}}">
                <option value="unimportant">Unimportant</option>
                    @if(!empty($attribute->attribute_values))
                        @foreach($attribute->attribute_values as $attribute_value)
                            <option value="{{ $attribute_value->id }}">{{ translate($attribute_value->value) }}</option>
                        @endforeach
                    @endif
                </select>
                <p>{!! htmlspecialchars($attribute->description) !!}</p>
            </div>
        </div>
    @endforeach
</div>
@endif
