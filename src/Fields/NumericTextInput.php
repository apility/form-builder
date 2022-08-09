<?php

namespace Netflex\FormBuilder\Fields;

/**
 *
 *
 */
class NumericTextInput extends BaseField
{
    public ?string $required = null;
    public ?string $question = null;
    public ?string $description = null;
    public ?string $min = null;
    public ?string $max = null;
    public ?string $step = null;

    public function formQuestion(): string
    {
        return $this->question ?? "Question is missing";
    }

    public function formDescription(): ?string
    {
        return $this->description;
    }

    public function render()
    {
        $valueRange = collect([$this->min, $this->max])
            ->filter(fn($f) => is_numeric($f))
            ->join(" - ");

        return view("form-builder::form-fields.numeric-text-input", [
            'question' => $this->formQuestion(),
            'description' => $this->formDescription(),
            'placeholder' => $valueRange ? __("form-builder.question.numeric-text-input.placeholder", ['range' => $valueRange]) : "",
            'min' => $this->min,
            'max' => $this->max,
            'required' => !!$this->required,
            'step' => $this->step,
        ]);
    }

    function formValidators(): array
    {
        $rules = $this->required ? ['required'] : [];

        $rules[] = "numeric";

        if(is_numeric($this->min)) {
            $rules[] = "min:{$this->min}";
        }

        if(is_numeric($this->max)) {
            $rules[] = "max:{$this->max}";
        }
        return $rules;
    }

    function formValidationMessages(): array
    {
        return [
            'required' => __("form-builder.question.numeric-text-input.required", ['name' => $this->formQuestion()]),
            'min' => __("form-builder.question.numeric-text-input.min", ['name' => $this->formQuestion(), 'count' => $this->min]),
            'max' => __("form-builder.question.numeric-text-input.max", ['name' => $this->formQuestion(), 'count' => $this->max]),
            'numeric' => __("form-builder.question.numeric-text-input.numeric", ['name' => $this->formQuestion()])
        ];
    }
}
