<?php

namespace Netflex\FormBuilder\Components;

use Illuminate\Container\Container;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;
use Netflex\FormBuilder\Exceptions\InvalidArgumentException;
use Netflex\FormBuilder\Fields\BaseField;
use Netflex\FormBuilder\Interfaces\FormFieldRepository;
use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\FormBuilder\Traits\ErrorBagResolver;
use Netflex\FormBuilder\Traits\ResolveFormModelFields;

class Form extends Component
{
    use ResolveFormModelFields;
    use ErrorBagResolver;


    protected FormModel $form;
    protected bool $csrf;
    protected MessageBag $errors;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(FormModel $form, bool $csrf = true)
    {
        $this->form = $form;
        $this->csrf = $csrf;
        $this->errors = $this->getErrorBag($this->form);
    }

    public function render()
    {
        $data = $this->resolveFormModelFields($this->form);

        return view("form-builder::components.form", [
            'fields' => $data,
            'csrf' => !!$this->csrf,
            'formErrors' => $this->errors,
        ])->withErrors($this->errors);
    }

    public function renderField(BaseField $field, int $index) {
        $data = $field->render();

        if($data instanceof \Illuminate\View\View) {
            $data->withErrors($this->errors)->with('fieldErrors', $this->errors->get($this->form->getFormFieldRuleName($index)));
        }

        return $data;
    }

}
