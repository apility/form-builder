<?php

namespace Netflex\FormBuilder\Interfaces;

interface FormModel
{
    public function getFormAttributeKey(): string;
    public function getFormFieldName(int $index): string;
    public function getFormFieldRuleName(int $index): string;

    public function getErrorBagName(): string;

}
