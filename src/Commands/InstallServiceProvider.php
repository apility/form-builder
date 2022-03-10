<?php

namespace Netflex\FormBuilder\Commands;

use Illuminate\Console\Command;

class InstallServiceProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'form-builder:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bootstraps the Form builder in the current laravel project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(!file_exists(app_path("Providers/FormBuilderServiceProvider.php")) || $this->confirm("Do you want to overwrite the existing service provider with the default configurations?", false)) {
            $this->info("Generating service provider");
            $data = file_get_contents(__DIR__ . "/../../templates/FormBuilderServiceProvider.php");
            file_put_contents(app_path("Providers/FormBuilderServiceProvider.php"), $data);
        }

        return 0;
    }
}
