
@if(!empty($attribute_camera))
    <div class="row {{ 'camera_div_'.$i }}">
        @foreach($attribute_camera as $attribute)

            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                <label>{{ $attribute->name }}</label>
                <select name="products[camera][{{$i}}][{{ $attribute->id }}]" id="camera_attributes" class="attribute" data-count="{{ $i }}" data-product_type="camera" data-system_type="{{ $system_type }}">
                    <option value="unimportant">Unimportant</option>
                        @if(!empty($attribute->attribute_values))
                            @foreach($attribute->attribute_values as $attribute_value)
                                <option value="{{ $attribute_value->id }}">{{ $attribute_value->value }}</option>
                            @endforeach
                        @endif
                    </select>
                    <p><?php echo htmlspecialchars($attribute->description);?></p>
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
                    <select name="products[recorder][{{$i}}][{{ $attribute->id }}]" id="recorder_attributes" class="attribute" data-count="{{ $i }}" data-product_type="recorder" data-system_type="{{ $system_type }}"> 
                        <option value="unimportant">Unimportant</option>
                        @if(!empty($attribute->attribute_values))
                            @foreach($attribute->attribute_values as $attribute_value)
                                <option value="{{ $attribute_value->id }}">{{ $attribute_value->value }}</option>
                            @endforeach
                        @endif
                    </select>
                    <p><?php echo htmlspecialchars($attribute->description);?></p>
                </div>
            </div>
        @endforeach
    </div>
@endif




    @if(!empty($attributes))
    <div class="row {{ $product_type.'_div_'.$i }} update">
 
        @foreach($attributes as $attribute_id => $attribute)
    
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                    @if(!empty($attribute['attribute_values']))
                    
                <label>{{ $attribute['attribute_name'] }}</label>
                <select name="products[{{ $product_type }}][{{$i}}][{{ $attribute_id }}]" id="{{ $product_type.'_attributes' }}" class="attribute"  data-count="{{ $i }}" data-product_type="{{ $product_type }}" data-system_type="{{ $system_type }}"> 
                        <option value="unimportant">Unimportant</option>
                            @foreach($attribute['attribute_values'] as $key => $value)
                                <option value="{{ $key }}" @if(in_array($key, $attribute_value_id)) selected @endif>{{ $value }}</option>
                            @endforeach
                    
                    </select>
                    <p><?php echo htmlspecialchars($attribute->description);?></p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    @endif



@if(!empty($attributes_new_product))
<div class="row {{ $product_type.'_div_'.$i }}">
    @foreach($attributes_new_product as $attribute)

        <div class="col-lg-3 col-md-6">
            <div class="form-group">
            <label>{{ $attribute->name }}</label>
            <select name="products[{{ $product_type }}][{{$i}}][{{ $attribute->id }}]" id="{{ $product_type.'_attributes' }}" class="attribute" data-product_type="{{ $product_type }}" data-system_type="{{ $system_type }}">
                <option value="unimportant">Unimportant</option>
                    @if(!empty($attribute->attribute_values))
                        @foreach($attribute->attribute_values as $attribute_value)
                            <option value="{{ $attribute_value->id }}">{{ $attribute_value->value }}</option>
                        @endforeach
                    @endif
                </select>
                <p><?php echo htmlspecialchars($attribute->description);?></p>
            </div>
        </div>
    @endforeach
</div>
@endif