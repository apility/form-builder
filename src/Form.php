<?php

namespace Netflex\FormBuilder;

use Illuminate\Container\Container;
use Netflex\FormBuilder\Exceptions\UnknownTypeException;
use Netflex\FormBuilder\Interfaces\FormModel;
use Netflex\FormBuilder\Providers\ComponentProvider;

class Form
{
    public bool $loaded = false;
    private array $fields = [];
    /**
     *
     * @throws UnknownTypeException
     */
    public function __construct(FormModel $model, ?Container $container = null)
    {
        $instance = $container ?? \Illuminate\Container\Container::getInstance();
        $types = $instance->get(ComponentProvider::FIELD_KEY);
        $data = $model->attributes[$model->getFormAttributeKey()];

        foreach ($data as $matrixBlock) {
            if(!array_key_exists($matrixBlock['type'], $types)) {
                throw new UnknownTypeException($matrixBlock['type']);
            }
            $this->fields[] = new $types[$matrixBlock['type']]($matrixBlock);
        }
        $this->loaded = true;
    }


}
