<?php
namespace Netflex\FormBuilder\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Netflex\FormBuilder\Commands\Install;
use Netflex\FormBuilder\Components\Form;
use Netflex\FormBuilder\Components\ValidationErrors;

class BaseProvider extends ServiceProvider {

    public function register()
    {
        parent::register();
    }

    public function boot() {
        $this->loadViewsFrom(__DIR__ . "/../../resources", "form-builder");
        Blade::component(Form::class, 'form-builder::form');
        Blade::component(ValidationErrors::class, 'form-builder::validation-errors');
    }
}
