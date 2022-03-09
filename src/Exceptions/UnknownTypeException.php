<?php

namespace Netflex\FormBuilder\Exceptions;

use Illuminate\Container\Container;
use Netflex\FormBuilder\Providers\ComponentProvider;
use Throwable;

class UnknownTypeException extends FormBuilderException
{
    public function __construct(string $wrongType, Throwable $previous = null)
    {
        $container = Container::getInstance();
        $types = collect($container->get(ComponentProvider::FIELD_KEY))->keys()->join(",") ?: "no valid types";
        parent::__construct("Unknown type $wrongType, valid types are: $types", 100, $previous);
    }
}
