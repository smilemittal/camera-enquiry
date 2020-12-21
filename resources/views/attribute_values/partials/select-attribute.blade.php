@foreach($attributes as $attribute)
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="text" id="attribute" data-attribute_id="{{ $attribute->id }}" value="{{ $attribute->name }}" readonly class="form-control">
           
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <select name="attribute_value[{{ $attribute->id }}]" id="" class="form-control">
                <option value="">Select</option>
                @if(!empty($attribute->attribute_values))
                    @foreach($attribute->attribute_values as $value) 
                        <option value="{{ $value->id }}">{{ $value->value }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
@endforeach