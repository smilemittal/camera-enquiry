@foreach ($attributes as $attribute)
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" id="attribute" data-attribute_id="{{ $attribute->id }}"
                    value="{{ $attribute->name }}" readonly class="form-control">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <select name="attribute_value[{{ $attribute->id }}]" id="" class="form-control">
                    <option value="">{{ translate('Select') }}</option>
                    @if (!empty($attribute->attribute_values))
                        @foreach ($attribute->attribute_values as $value)
                            @if($value->standard_id == $standard && $value->system_type_id == $system_type && $value->type_id == $type)
                                <option value="{{ $value->id }}">{{ $value->value }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
@endforeach
