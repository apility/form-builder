<?php

namespace Netflex\FormBuilder\Commands;

class MakeFormBuilderRequest extends \Illuminate\Foundation\Console\RequestMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:form-builder-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form builder request class';

    protected function resolveStubPath($stub)
    {
        return __DIR__.$stub;
    }
}
