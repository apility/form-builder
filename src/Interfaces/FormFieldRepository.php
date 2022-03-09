<?php

namespace Netflex\FormBuilder\Interfaces;

use Netflex\FormBuilder\Fields\BaseField;

interface FormFieldRepository {
    function registerField(string $matrixType, string $class);
    function transform($object): FormField;
    function getSupportedFields(): array;
}
