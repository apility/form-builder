<?php

namespace Netflex\FormBuilder\Interfaces;

interface NameResolvableFormField extends FormField {
    function getResolveByName(): string;
}
