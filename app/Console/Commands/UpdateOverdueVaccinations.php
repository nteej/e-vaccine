<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateOverdueVaccinations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaccinations:update-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update overdue status for vaccinations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('vaccinations')
        ->whereNotNull('next_due_date')
        ->where('next_due_date', '<', now()->startOfDay())
        ->update(['is_overdue' => true]);

    $this->info('Overdue vaccinations have been updated.');
    //# Add to crontab
    // * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
    }
}
