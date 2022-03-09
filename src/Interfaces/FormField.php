<?php

namespace Netflex\FormBuilder\Interfaces;

use Illuminate\Contracts\Support\Renderable;

interface FormField extends Renderable
{
    /**
     *
     * The name of the field.
     *
     * @return string
     */
    public function formName(): string;

    /**
     *
     * The visible question that the user is presented with
     *
     * @return string
     */
    public function formQuestion(): string;

    /**
     *
     * A visible subtext
     *
     * @return string
     */
    public function formDescription(): ?string;


    /**
     *
     * Informs the FormField of the form it belongs to.
     *
     * @param FormModel $form
     * @return $this
     */
    public function setFormModel(FormModel $form): self;

    /**
     * Informs the field of the name it is supposed to have
     *
     * @param string $name
     * @return $this
     */
    public function setFormName(string $name): self;

    /**
     * Return a list of form validation rules the same way laravel does it when making Requests(must use array syntarx, not string)
     *
     * For example `['required', 'min:2']` etc.
     * @return array
     */
    public function formValidators(): array;

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
    public function formValidationMessages(): array;


}
