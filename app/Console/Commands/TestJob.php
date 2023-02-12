<?php

namespace App\Console\Commands;

use App\Models\Companies;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TestJob extends Command
{
    /**
     * The name and signature of the console command.
     *s
     * @var string
     */
    protected $signature = 'test:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tarea de pruebapj';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $company = new Companies();
        $company->social_reason = Str::random(20);
        $company->rfc = Str::random(12);
        $company->save();
        return Command::SUCCESS;
    }
}
