<?php

namespace Netflex\FormBuilder\Fields;

/**
 *
 *
 */
class TextInput extends BaseField
{
    private $required;
    private $question;
    private $description;

    public function formName(): string
    {
        return $this->question ?? "question is missing";
    }

    public function formQuestion(): string
    {
        return $this->question ?? "Question is missing";
    }

    public function formDescription(): ?string
    {
        return $this->description;
    }

    public function isRequired(): bool
    {
        return !!$this->required;
    }

    public function render()
    {
        return '<input type="' . $this->formName() . '">'
    }
}
