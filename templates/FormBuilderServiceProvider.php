<?php

namespace App\Providers;

use Netflex\FormBuilder\Fields\TextInput;
use Netflex\FormBuilder\Interfaces\FormFieldRepository;
use Netflex\FormBuilder\Providers\FormBuilderServiceProvider as FormBuilderBaseServiceProvider;

class FormBuilderServiceProvider extends FormBuilderBaseServiceProvider
{

    function boot(FormFieldRepository $repo)
    {
        // Use $repo->registerField to register form builder components
    }
}
