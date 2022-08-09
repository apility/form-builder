<?php

namespace Netflex\FormBuilder\Fields;

use Illuminate\View\Component;
use Netflex\FormBuilder\Interfaces\FormField;
use Netflex\FormBuilder\Interfaces\FormModel;

abstract class BaseField extends Component implements FormField
{

    public ?FormModel $form = null;


    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }


    /**
     *
     * The visible question that the user is presented with
     *
     * @return string
     */
    abstract function formQuestion(): string;

    /**
     *
     * The question description. In standard components, this is shown beneath the form input
     * and has more descriptive texts for the question
     *
     * @return string|null
     */
    abstract function formDescription(): ?string;

    /**
     *
     * Informs the FormField of the form it belongs to
     *
     * @param FormModel $form
     * @return $this
     */
    public function setFormModel(FormModel $form): self
    {
        $this->form = $form;
        return $this;
    }

    /**
     * Return a list of form validation rules the same way laravel does it when making Requests(must use array syntarx, not string)
     *
     * For example `['required', 'min:2']` etc.
     * @return array
     */
    abstract function formValidators(): array;

    /**
     * Returns a list of validation messages that can be presented to the user in the case of a validation error.
     *
     * In standard laravel we can supply this to the messages() function as such.
     *
     * ```
     * public function messages() {
     *   return [
     *      'field.required' => 'field is required'
     *   ];
     * }
     * ```
     *
     * This array is similar but we omit the field name part of the array
     *
     * ```
     * public function formValidationMessages() {
     *   return [
     *      'required' => 'field is required'
     *   ];
     * }
     * ```
     *
     * @return array
     */
    abstract function formValidationMessages(): array;

}
