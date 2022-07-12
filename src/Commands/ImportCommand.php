<?php

namespace Baron\Recombee\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recombee:import
            {--u|users : Bulk import users} 
            {--i|items : Bulk import items}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import recommendable models into the index.';

    /**
     * Execute the console command.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function handle(Dispatcher $events)
    {
        $importUsers = $this->option('users');
        $importItems = $this->option('items');
        $importBoth = ! $importUsers && ! $importItems;

        $userClass = config('recombee.user');
        $itemClass = config('recombee.item');

        if ($importBoth || $importUsers) {
            $userClass::makeAllRecommendable();
            $this->info('All ['.$userClass.'] records have been imported.');
        }

        if ($importBoth || $importItems) {
            $itemClass::makeAllRecommendable();
            $this->info('All ['.$itemClass.'] records have been imported.');
        }

        return self::SUCCESS;
    }
}
