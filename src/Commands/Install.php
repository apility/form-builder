<?php

namespace Netflex\FormBuilder\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'form-builder:install {className : Name of the Form class that will be generated} {structure}';

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
        echo config("form-builder.test", "vet ikke");

        $className = $this->argument("className");
        $structure = $this->argument("structure");
        if(!file_exists(config_path("form-builder.php")) || $this->confirm("Do you want to overwrite the existing config with the default configurations?", false)) {
            $this->info("Generating form builder configurations");

            $data = file_get_contents(__DIR__ . "/../../templates/config.php");
            $data = str_replace("ClassName", $className, $data);
            file_put_contents(config_path("form-builder.php"), $data);
        }

        if(!file_exists(app_path("Models/Form.php")) || $this->confirm("Do you want to overwrite the existing base model with the default configurations?", false)) {
            $this->info("Generating model class");

            $data = file_get_contents(__DIR__ . "/../../templates/model.php");
            $data = str_replace("ClassName", $className, $data);
            $data = str_replace("__ID__", $structure, $data);

            file_put_contents(app_path("Models/$className.php"), $data);
        }

        return 0;
    }
}
