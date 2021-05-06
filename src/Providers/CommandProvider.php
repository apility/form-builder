<?php
namespace Netflex\FormBuilder\Providers;

use Illuminate\Support\ServiceProvider;
use Neflex\FormBuilder\Commands\Install;

class CommandProvider extends ServiceProvider {

    public function register()
    {
        $this->commands([
            Install::class
        ]);
        parent::register();
    }
}
