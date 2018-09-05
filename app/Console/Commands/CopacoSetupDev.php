<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CopacoSetupDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copaco:setup_dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configura usuário desenvolvedor no sistema';

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
        if (!\App::environment('local')) {
            $erro = "[ ERRO ]" .  PHP_EOL . "Configure seu ambiente para 'local' em seu arquivo .env";
            $this->error($erro);
            exit(1);
        }
        $this->info("Gerando usuário para dev...");
        // Chamando o seeder
        $this->call('db:seed', [
            '--class' => 'DevUserSeeder'
        ]);
    }
}
