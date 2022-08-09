<?php

namespace Netflex\FormBuilder\Interfaces;

interface FormModel
{
    public function getFormAttributeKey(): string;
    public function getFormFieldName(int $index, FormField $model): string;
    public function getFormFieldRuleName(int $index, FormField $model): string;

    public function getErrorBagName(): string;

}
