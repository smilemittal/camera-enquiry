@if(!empty($attribute_camera))
    @foreach($attribute_camera as $attribute)

        <div class="col-lg-3 col-md-6">
            <div class="form-group">
            <label>{{ $attribute->name }}</label>
            <select name="attributes[]" id="camera_attributes" class="attribute" data-product_type="camera" data-system_type="{{ $system_type }}">
                <option value="">Select</option>
                    @if(!empty($attribute->attribute_values))
                        @foreach($attribute->attribute_values as $attribute_value)
                            <option value="{{ $attribute_value->id }}">{{ $attribute_value->value }}</option>
                        @endforeach
                    @endif
                </select>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
            </div>
        </div>
    @endforeach
@endif


@if(!empty($attribute_recorder))
    @foreach($attribute_recorder as $attribute)

        <div class="col-lg-3 col-md-6">
            <div class="form-group">
            <label>{{ $attribute->name }}</label>
                <select name="attributes[]" id="recorder_attributes" class="attribute" data-product_type="recorder" data-system_type="{{ $system_type }}"> 
                    <option value="">Select</option>
                    @if(!empty($attribute->attribute_values))
                        @foreach($attribute->attribute_values as $attribute_value)
                            <option value="{{ $attribute_value->id }}">{{ $attribute_value->value }}</option>
                        @endforeach
                    @endif
                </select>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
            </div>
        </div>
    @endforeach
@endif


@if(!empty($attributes))
{{-- @dd($attributes[170]) --}}
    @foreach($attributes as $attribute)
    
        <div class="col-lg-3 col-md-6">
            <div class="form-group">
                @if(!empty($attribute['attribute_values']))
                
            <label>{{ $attribute['attribute_name'] }}</label>
            <select name="attributes[]" id="{{ $product_type.'_attributes' }}" class="attribute" data-product_type="{{ $product_type }}" data-system_type="{{ $system_type }}"> 
                    <option value="">Select</option>
                        @foreach($attribute['attribute_values'] as $key => $value)
                            <option value="{{ $key }}" @if(in_array($key, $attribute_value_id)) selected @endif>{{ $value }}</option>
                        @endforeach
                   
                </select>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                @endif
            </div>
        </div>
    @endforeach
@endif