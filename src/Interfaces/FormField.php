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
     * If true, this field will be marked as
     *
     * @return bool
     */
    public function isRequired(): bool;



}
