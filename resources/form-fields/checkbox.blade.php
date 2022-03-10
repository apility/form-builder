<div class="mb-4">
    <label class="form-label form-builder-label" for="{{ $formName }}">
        {{ $question }}
        @if($required)
            <span class="form-builder-asterisk text-danger font-mono">*</span>
        @endif

    </label>

    <div class="form-check mb-2">
        <input type="checkbox"
               class="form-check-input form-builder-checkbox"
               id="{{ $formName }}"
               name="{{ $formName }}"
               {{ old($ruleName) ? "checked" : "" }}
        >
        <label for="{{ $formName }}" class="form-builder-checkbox-label">{{ $labelText ?? $question }}</label>
    </div>
    @if($fieldErrors)
        <span class="form-builder-description text-danger">{{ $fieldErrors[0] }}</span>
    @else
        @if($description)
            <span class="form-builder-description">{{ $description }}</span>
        @endif
    @endif
</div>
