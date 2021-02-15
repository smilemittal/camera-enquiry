
@foreach($standards as $standard) 
    <option value="{{ $standard->id }}">{{ $standard->name }}</option>
@endforeach
                   