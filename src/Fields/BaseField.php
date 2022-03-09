<?php

namespace Netflex\FormBuilder\Fields;

use Illuminate\View\Component;
use Netflex\FormBuilder\Interfaces\FormField;
use Netflex\FormBuilder\Interfaces\FormModel;

abstract class BaseField extends Component implements FormField
{

    public ?FormModel $form = null;
    public string $name;
    public string $errorBagName;
    function formName(): string {
        return $this->name;
    }

    abstract function formQuestion(): string;

    abstract function formDescription(): ?string;

    public function __construct(array $data) {
        foreach($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function setFormModel(FormModel $form): self {
        $this->form = $form;
        $this->errorBagName = $form->getErrorBagName();
        return $this;
    }

    public function setFormName(string $name): self {
        $this->name = $name;
        return $this;
    }


    abstract function formValidators(): array;
    abstract function formValidationMessages(): array;

}
