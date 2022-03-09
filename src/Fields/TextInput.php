<?php

namespace Netflex\FormBuilder\Fields;

/**
 *
 *
 */
class TextInput extends BaseField
{
    public $required;
    public $question;
    public $description;

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
            'formName' => $this->formName(),
            'question' => $this->question,
            'description' => $this->description
        ]);
    }

    function formValidators(): array
    {
        return $this->required ? ['required'] : [];
    }

    function formValidationMessages(): array
    {
        return [
            'required' => "Du må fylle inn '{$this->question}' feltet",
        ];
    }
}
