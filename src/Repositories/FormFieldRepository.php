<?php

namespace Netflex\FormBuilder\Repositories;

use Illuminate\Support\Collection;
use Netflex\FormBuilder\Exceptions\UnknownTypeException;
use Netflex\FormBuilder\Fields\BaseField;

class FormFieldRepository implements \Netflex\FormBuilder\Interfaces\FormFieldRepository {

    private Collection $content;

    public function __construct()
    {
        $this->content = collect();
    }

    function registerField(string $matrixType, string $class)
    {
        $this->content[$matrixType] = $class;
    }


    function transform( $object): BaseField
    {
        if(is_array($object)) {
            $object = (array)$object;
        }

        if($this->content[$object['type']]) {
            return new $this->content[$object['type']]($object);
        }

        throw new UnknownTypeException($object['type']);

    }

    function getSupportedFields(): array
    {
        return $this->content->keys()->toArray();
    }
}
