
@foreach ($fields as $key => $field)
    <div class="{{$col}}">
        <div class="form-group">
            <label>{{ ucwords(str_replace('_', ' ', $field)) }}</label>
            <input class="form-control" type="text" id="{{$field}}_{{$target}}" name="{{$field}}" value="" placeholder="{{ ucwords(str_replace('_', ' ', $field)) }}" >
            <small class="text-danger" id="{{$target}}_{{$field}}"></small>
        </div>
    </div>
@endforeach
