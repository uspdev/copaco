<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeployAdminlteAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Faz o deploy dos assets do AdminLTE na pasta /public/vendor';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info("Deploying Assets...");

        // Calling the service provider
        $this->call('vendor:publish',[
            '--provider' => 'JeroenNoten\LaravelAdminLte\ServiceProvider',
            '--tag' => 'assets'
        ]);
    }
}
