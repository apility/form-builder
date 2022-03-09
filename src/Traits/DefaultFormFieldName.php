<?php

namespace Netflex\FormBuilder\Traits;

trait DefaultFormFieldName
{
    public function getFormFieldName(int $index): string
    {
        return "questions[$index]";
    }

    public function getFormFieldRuleName(int $index): string
    {
        return "questions.$index";
    }



}
