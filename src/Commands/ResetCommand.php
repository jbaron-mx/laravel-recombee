<?php

namespace Baron\Recombee\Commands;

use Baron\Recombee\Builder;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;

class ResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recombee:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Erases all data in your Recombee database, including users, items, and interactions.';

    /**
     * Execute the console command.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return int
     */
    public function handle(Dispatcher $events)
    {
        app()->make(Builder::class)->reset();

        $this->info('All data in ['.config('recombee.database').'] has been erased.');

        return self::SUCCESS;
    }
}
