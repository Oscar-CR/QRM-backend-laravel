<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OrdersTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene las ordenes apartir del bmps';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        
        return Command::SUCCESS;
    }
}
