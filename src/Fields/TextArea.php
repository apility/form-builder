<?php

namespace Netflex\FormBuilder\Fields;

class TextArea extends BaseField
{

    public ?string $question = null;
    public ?string $description = null;
    public ?string $placeholder = null;
    public $required = null;
    public string $columns = "10";

    function formQuestion(): string
    {
        return $this->question ?? "";
    }

    function formDescription(): ?string
    {
        return $this->description;
    }

    function formValidators(): array
    {
        return $this->required ? ['required'] : [];
    }

    function formValidationMessages(): array
    {
        return [
            'required' => __("form-builder.question.text-area.required", ['name' => $this->formQuestion()]),
        ];
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view("form-builder::form-fields.text-area", [
            'question' => $this->formQuestion(),
            'description' => $this->formDescription(),
            'placeholder' => $this->placeholder,
            'required' => !!$this->required,
            'columns' => $this->columns,
        ]);
    }
}
