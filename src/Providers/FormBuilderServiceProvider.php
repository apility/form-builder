<?php


namespace Netflex\FormBuilder\Providers;


use Netflex\FormBuilder\Interfaces\FormFieldRepository;

abstract class FormBuilderServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public const FIELD_KEY = "form-builder-fields";
    public const RENDERER_KEY = "form-builder-renderer";


    public function register()
    {
        $this->app->singleton(FormFieldRepository::class, \Netflex\FormBuilder\Repositories\FormFieldRepository::class);
    }

    abstract function boot(FormFieldRepository $repo);
}
