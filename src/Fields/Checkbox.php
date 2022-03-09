<?php

namespace Netflex\FormBuilder\Fields;

/**
 *
 *
 */
class Checkbox extends BaseField
{
    public $required;
    public $question;
    public $description;
    public $labelText;

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
        return view("form-builder::form-fields.checkbox", [
            'formName' => $this->formName(),
            'question' => $this->formQuestion(),
            'description' => $this->formDescription(),
            'labelText' => $this->labelText,
            'required' => !!$this->required,
        ]);
    }

    function formValidators(): array
    {
        return $this->required ? ['required'] : [];
    }

    function formValidationMessages(): array
    {
        return [
            'required' => __("form-builder.question.checkbox.required", ['name' => $this->formQuestion()]),
        ];
    }
}
