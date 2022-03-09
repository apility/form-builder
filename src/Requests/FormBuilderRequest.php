<?php

namespace Netflex\FormBuilder\Requests;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Netflex\FormBuilder\Interfaces\FormField;
use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\FormBuilder\Traits\ResolveFormModelFields;

;

abstract class FormBuilderRequest extends FormRequest
{
    use ResolveFormModelFields;

    /// After first resolve, we store the instance in case it is slow to retrieve
    private ?FormModel $form;

    /**
     * @return string
     */
    public function getErrorBag(): string
    {
        if ($this->_form()) {
            return $this->_form()->getErrorBagName();
        }
        return $this->errorBag;
    }

    private function _form(): ?FormModel
    {
        if (!isset($this->form)) {
            $this->form = $this->getForm();
        }
        return $this->form;
    }

    abstract function getForm(): ?FormModel;

    /**
     * Create the default validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Factory $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        $formFields = [];
        $formMessages = [];

        if ($form = $this->_form()) {
            $fields = $this->resolveFormModelFields($form);

            $formFields = collect($fields)
                ->mapWithKeys(fn(FormField $field, $i) => [$form->getFormFieldRuleName($i) => $field->formValidators()])
                ->toArray();

            $formMessages = collect($fields)
                ->mapWithKeys(fn(FormField $field, $i) => [$form->getFormFieldRuleName($i) => $field->formValidationMessages()])
                ->reduce(fn($p, $messages, $prefix) => array_merge(
                    $p,
                    collect($messages)->mapWithKeys(fn($v, $k) => [$prefix . "." . $k => $v])->toArray(),
                ), []);
        }

        $rules = array_merge($formFields, $this->container->call([$this, 'rules']));
        $messages = array_merge($formMessages, $this->messages());

        return $factory->make(
            $this->validationData(), $rules,
            $messages, $this->attributes(),
        )->stopOnFirstFailure($this->stopOnFirstFailure);
    }


    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->errorBag($this->getErrorBag())
            ->redirectTo($this->getRedirectUrl());
    }

}
