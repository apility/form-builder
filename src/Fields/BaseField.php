<?php

namespace Netflex\FormBuilder\Fields;

use Netflex\FormBuilder\Interfaces\FormField;

abstract class BaseField implements FormField
{

    public function __construct(array $data) {
        foreach($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
