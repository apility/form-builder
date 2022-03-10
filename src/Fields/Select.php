<?php

namespace Netflex\FormBuilder\Fields;
class Select extends \Netflex\FormBuilder\Fields\BaseField
{

    public $required;
    public $question;
    public $description;
    public ?string $options;

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

        $options = collect(explode("\n", $this->options ?? ""))
        ->map(fn($str) => trim($str))
        ->filter()
        ->values();

        return view("form-builder::form-fields.select", [
            'question' => $this->formQuestion(),
            'description' => $this->formDescription(),
            'required' => !!$this->required,
            'options' => $options,
        ]);
    }

    function formValidators(): array
    {
        return $this->required ? ['required'] : [];
    }

    function formValidationMessages(): array
    {
        return [
            'required' => __("form-builder.question.select.required", ['name' => $this->formQuestion()]),
        ];
    }
}
