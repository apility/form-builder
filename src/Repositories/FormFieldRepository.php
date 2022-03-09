<?php

namespace Netflex\FormBuilder\Repositories;

use Illuminate\Support\Collection;
use Netflex\FormBuilder\Exceptions\UnknownTypeException;
use Netflex\FormBuilder\Fields\BaseField;

class FormFieldRepository implements \Netflex\FormBuilder\Interfaces\FormFieldRepository {

    private Collection $content;
    private Collection $overrides;


    public function __construct()
    {
        $this->content = collect();
        $this->overrides = collect();
    }

    function registerField(string $matrixType, string $class, ?array $overrides = null)
    {
        $this->content[$matrixType] = $class;

        if($overrides) {
            $this->overrides[$matrixType] = $overrides;
        }
    }


    function transform( $object): BaseField
    {
        if(is_array($object)) {
            $object = (array)$object;
        }

        if($this->content[$object['type']] ?? null) {
            return new $this->content[$object['type']](array_merge($object, $this->overrides[$object['type']] ?? []));
        }

        throw new UnknownTypeException($object['type']);

    }

    function getSupportedFields(): array
    {
        return $this->content->keys()->toArray();
    }
}
