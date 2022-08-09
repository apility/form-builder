<?php
namespace Netflex\FormBuilder\Providers;

use Illuminate\Support\ServiceProvider;
use Netflex\FormBuilder\Commands\InstallServiceProvider;
use Netflex\FormBuilder\Commands\MakeFormBuilderRequest;

class CommandProvider extends ServiceProvider {

    public function register()
    {
        $this->commands([
            InstallServiceProvider::class,
            MakeFormBuilderRequest::class,
        ]);
        parent::register();
    }
}
