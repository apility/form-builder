<?php

namespace Netflex\FormBuilder\Fields;

use Netflex\FormBuilder\Interfaces\NameResolvableFormField;

/**
 *
 *
 */
class TextInput extends BaseField
{
    public $required;
    public $question;
    public $description;
    public ?string $placeholder = "";
    public string $formType = "text";

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
        return view("form-builder::form-fields.text-input", [
            'question' => $this->formQuestion(),
            'description' => $this->formDescription(),
            'placeholder' => $this->placeholder,
            'required' => !!$this->required,
            'formType' => $this->formType ?: "text",
        ]);
    }

    function formValidators(): array
    {
        return $this->required ? ['required'] : [];
    }

    function formValidationMessages(): array
    {
        return [
            'required' => __("form-builder.question.text-input.required", ['name' => $this->formQuestion()]),
        ];
    }

}
