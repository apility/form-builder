<?php

namespace Netflex\FormBuilder\Traits;

use Netflex\FormBuilder\Interfaces\FormField;
use Netflex\FormBuilder\Interfaces\NameResolvableFormField;

trait DefaultFormFieldName
{
    public function getFormFieldName(int $index, FormField $field): string
    {
        if($field instanceof NameResolvableFormField) {
            return "questions[{$field->getResolveByName()}]";
        }
        return "questions[$index]";
    }

    public function getFormFieldRuleName(int $index, FormField $field): string
    {
        if($field instanceof NameResolvableFormField) {
            return "questions.{$field->getResolveByName()}";
        }

        return "questions.$index";
    }



}
