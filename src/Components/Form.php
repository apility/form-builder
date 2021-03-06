<?php

namespace Netflex\FormBuilder\Components;

use Illuminate\Container\Container;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;
use Netflex\FormBuilder\Exceptions\InvalidArgumentException;
use Netflex\FormBuilder\Interfaces\FormField;
use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\FormBuilder\Traits\ErrorBagResolver;
use Netflex\FormBuilder\Traits\ResolveFormModelFields;
use Netflex\Support\HtmlString;

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

    public function renderField(FormField $field, int $index) {

        if($field instanceof Component) {
            $data = $field->render();

            if($data instanceof \Illuminate\View\View) {
                return new HtmlString($data->withErrors($this->errors)
                    ->with($field->data())
                    ->with('fieldErrors', $this->errors->get($this->form->getFormFieldRuleName($index, $field)))
                    ->with('formName', $this->form->getFormFieldName($index, $field))
                    ->with('ruleName', $this->form->getFormFieldRuleName($index, $field))->render());
            }
            return $data;
        }

        return $field;
    }

}
