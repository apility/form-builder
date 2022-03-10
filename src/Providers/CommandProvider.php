<?php
namespace Netflex\FormBuilder\Providers;

use Illuminate\Support\ServiceProvider;
use Netflex\FormBuilder\Commands\InstallServiceProvider;

class CommandProvider extends ServiceProvider {

    public function register()
    {
        $this->commands([
            InstallServiceProvider::class
        ]);
        parent::register();
    }
}
