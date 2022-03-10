
<div class="mb-4">
    @dump(session()->all())
    @dump(old($formName))
    @dump(old($ruleName))
    <label class="form-label form-builder-label" for="{{ $formName }}">
        {{ $question }}
        @if($required)
            <span class="form-builder-asterisk text-danger font-mono">*</span>
        @endif
    </label>
    <input type="{{ $formType ?? "text" }}"
           class="form-control font-builder-text-input {{ $fieldErrors ? "is-invalid" : "" }}"
           id="{{ $formName }}"
           placeholder="{{ $placeholder ?? "" }}"
           name="{{ $formName }}"
           value="{{ old($ruleName) }}"
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
