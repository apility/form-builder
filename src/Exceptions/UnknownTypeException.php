<?php

namespace Netflex\FormBuilder\Exceptions;

use Illuminate\Container\Container;
use Netflex\FormBuilder\Interfaces\FormFieldRepository;
use Netflex\FormBuilder\Providers\FormBuilderServiceProvider;
use Throwable;

class UnknownTypeException extends FormBuilderException
{
    public function __construct(string $wrongType, Throwable $previous = null)
    {
        $container = Container::getInstance();
        $types = $container->get(FormFieldRepository::class)->getSupportedFields();
        $types = collect($types)->join(", ") ?: "no valid types";
        parent::__construct("Unknown type $wrongType, valid types are: $types. Have you forgotten to register it?", 100, $previous);
    }
}
