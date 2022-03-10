
<div class="mb-4">
    <label class="form-label form-builder-label" for="{{ $formName }}">
        {{ $question }}
        @if($required)
            <span class="form-builder-asterisk text-danger font-mono">*</span>
        @endif
    </label>
    <input type="number"
           class="form-control font-builder-numeric-text-input {{ $fieldErrors ? "is-invalid" : "" }}"
           id="{{ $formName }}"
           placeholder="{{ $placeholder ?? "" }}"
           name="{{ $formName }}"
           value="{{ old($ruleName) }}"
            {{ $max ? "max=$max" : "" }}
            {{ $min ? "min=$min" : "" }}

            {{ $required ? "required" : "" }}
    >
    @if($fieldErrors)
        <span class="form-builder-description text-danger">{{ $fieldErrors[0] }}</span>
    @else
        @if($description)
            <span class="form-builder-description">{{ $description }}</span>
        @endif
    @endif
</div>
