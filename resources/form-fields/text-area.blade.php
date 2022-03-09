<div class="mb-4">
    <label class="form-label" for="{{ $formName }}">
        {{ $question }}
        @if($required)
            <span class="form-builder-asterisk text-danger font-mono">*</span>
        @endif
    </label>


    <textarea class="form-control form-builder-text-area {{ $fieldErrors ? "is-invalid" : "" }}"
              id="{{ $formName }}"
              placeholder="{{ $placeholder ?? "" }}"
              name="{{ $formName }}"
              {{ $required ? "required" : "" }}
              rows="{{ $columns }}">{{ old($formName) }}</textarea>
    @if($fieldErrors)
        <span class="form-description text-danger">{{ $fieldErrors[0] }}</span>
    @else
        @if($description)
            <span class="form-description">{{ $description }}</span>
        @endif
    @endif

</div>
