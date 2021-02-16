
@if(!empty($attributes))
    <div class="row {{ $type->slug.'_div_'.$i }}">
        @foreach($attributes as $attribute)

            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                <label>{{ $attribute->name }}</label>
                <select name="products[{{$type->slug}}][{{$i}}][{{ $attribute->id }}]" id="{{$type->slug}}_attributes" class="attribute {{ in_array($attribute->name, ['Series of equipment', 'Number of channels']) ? $type->slug.'_cal_col' : '' }}" data-count="{{ $i }}" data-product_type="{{$type->slug}}" data-system_type="{{ $system_type }}" data-attribute="{{$attribute->id}}">
                    <option value="unimportant">Unimportant</option>
                        @if(!empty($attribute->attribute_values))
                            @foreach($attribute->attribute_values as $attribute_value)
                                @if(!empty($selected_attributes) && ($attribute_value->id == $selected_attributes[$attribute->id] || (!empty($filtered_attributes[$attribute->id]) && in_array($attribute_value->id, $filtered_attributes[$attribute->id]))))
                                    <option value="{{ $attribute_value->id }}" {{ $attribute_value->id == $selected_attributes[$attribute->id] ? 'selected' : '' }}>{{ translate($attribute_value->value)}}</option>
                                @else
                                    <option value="{{ $attribute_value->id }}">{{ translate($attribute_value->value)}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    <p>{!! htmlspecialchars($attribute->description) !!}</p>
                </div>
            </div>
        @endforeach
    </div>
@endif
