<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class UseTheForce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use:the_force';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows the Power of The Force';

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
     * Mostra a logo inicial
     *
     * @return string
     */
    public function show_logo()
    {
        $logo_text = __DIR__.'/rebel_logo.txt';
        $contents = File::get($logo_text);
        $this->info($contents);
    }

    /**
     * Mostra abertura Star Warzica
     *
     * TODO: Fazer do modo laravélico. Ou não.
     *
     * @return string
     */
    public function show_opening()
    {
        $opening = __DIR__.'/intro.txt';
        $file = fopen($opening, "r");
        
        while (! feof($file)) {
            $this->info(fgets($file));
            sleep(1);
        }
        fclose($file);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->show_logo();
        $this->show_opening();
    }
}
