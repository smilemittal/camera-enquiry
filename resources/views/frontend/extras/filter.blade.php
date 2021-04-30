@if(!empty($attributes))
    <div class="row {{ $type->slug.'_div_'.$i }}" data-type="{{$type->slug}}" data-count="{{ $i }}">
        @foreach($attributes as $attribute)
            @if ($type->name == 'recorder' && $attribute->name == 'Price')
            
            @else
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">
                    <label>{{ translate($attribute->name) }}</label>
                    <select name="products[{{$type->slug}}][{{$i}}][{{ $attribute->id }}]" id="{{$type->slug}}_attributes" class="reset_all_values attribute @if($attribute->name == 'Series of equipment') series_val @endif {{ in_array($attribute->name, ['Series of equipment', 'Number of channels']) ? $type->slug.'_cal_col' : '' }}" data-count="{{ $i }}" data-product_type="{{$type->slug}}" data-system_type="{{ $system_type }}" data-attribute="{{$attribute->id}}">
                        <option value="unimportant">{{translate('Unimportant')}}</option>
                            @if (!empty($attribute->attribute_values))
                                @php
                                    if(!empty($standard)){
                                        $attribute_values = $attribute->attribute_values()->where('standard_id', $standard)->get();
                                    }else{
                                        $attribute_values = $attribute->attribute_values;
                                    }
                                @endphp
                                @foreach($attribute_values as $attribute_value)
                                    @if(empty($selected_attributes))
                                        <option value="{{ $attribute_value->id }}">{{ translate($attribute_value->value)}}</option>
                                    @elseif(count($selected_attributes) > 0  && in_array($attribute_value->id, $filtered_attributes[$attribute->id])
                                    )
                                        <option value="{{ $attribute_value->id }}" {{ $attribute_value->id == $selected_attributes[$attribute->id] ? 'selected' : '' }}>{{ translate($attribute_value->value)}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <p>@if(!empty($attribute->description)){!! htmlspecialchars(translate($attribute->description)) !!} @endif</p>
                    </div>
                </div>
            @endif
        @endforeach
       
        <button type="button" class="btn btn-secondary reset" style="width: 30%;" id="reset" data-target="{{ $type->slug.'_div_'.$i }}">Reset</button>
    </div>
 
           
 
@endif
