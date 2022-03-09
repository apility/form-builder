
<div class="mb-4">
    <label class="form-label" id="{{ $formName }}">{{ $question }}</label>
    <input type="text" class="form-control {{ $errors }}" id="{{ $formName }}" placeholder="" name="{{ $formName }}"
           value="{{ old($formName) }}" >
    @if($description)
        <span class="">{{ $description }}</span>
    @endif
</div>
