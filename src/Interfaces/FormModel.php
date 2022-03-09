<?php

namespace Netflex\FormBuilder\Interfaces;

interface FormModel
{
    public function getFormAttributeKey(): string;
    public function getErrorBagName(): string;
}
