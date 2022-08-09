<div class="mb-4">
    <label class="form-label form-builder-label" for="{{ $formName }}">
        {{ $question }}
        @if($required)
            <span class="form-builder-asterisk text-danger font-mono">*</span>
        @endif
    </label>
    <select
            class="form-control form-builder-select {{ $fieldErrors ? "is-invalid" : "" }}"
            id="{{ $formName }}"
            name="{{ $formName }}"
    >
        @foreach($options as $option)
            <option
                    value="{{ $option }}"
                    {{ (old($ruleName) ?? $preselected()) == $option ? "selected" : "" }}
            >
                {{ $option }}
            </option>
        @endforeach
    </select>
    @if($fieldErrors)
        <span class="form-builder-description text-danger">{{ $fieldErrors[0] }}</span>
    @else
        @if($description)
            <span class="form-builder-description">{{ $description }}</span>
        @endif
    @endif
</div>
