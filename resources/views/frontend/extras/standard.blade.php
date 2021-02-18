@foreach ($standards as $standard)
    <div class="col-xl-3 col-md-4">
        <button type="button" class="standard {{ $standard->name }}" data-name="{{ $standard->name }}"
            data-id="{{ $standard->id }}">{{ translate($standard->name) }}</button>
    </div>
@endforeach
