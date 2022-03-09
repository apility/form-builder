@if($csrf)
    @csrf
@endif
@foreach($fields as $i => $field)
    {{ $renderField($field, $i) }}
@endforeach
