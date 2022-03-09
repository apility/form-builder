<?php
namespace Netflex\FormBuilder\Requests;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;
use Netflex\FormBuilder\Interfaces\Form;

;

abstract class FormBuilderRequest extends FormRequest {

    /// After first resolve, we store the instance in case it is slow to retrieve
    private ?Form $form;
    abstract function getForm(): ?Form;


    /**
     * Create the default validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Factory  $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        $rules = array_merge([], $this->container->call([$this, 'rules']));
        $messages = array_merge([], $this->messages());

        return $factory->make(
            $this->validationData(), $rules,
            $messages, $this->attributes()
        )->stopOnFirstFailure($this->stopOnFirstFailure);
    }


    private function addRequiredFormFields(array $rules) {
        if($form = $this->_form()) {
            foreach($form->requiredFields() as $d) {

            }
        }

        return $rules;
    }


    private function _form(): ?Form {
        if(!isset($this->form)) {
            $this->form = $this->getForm();
        }
        return $this->form;
    }

}
