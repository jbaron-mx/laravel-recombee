<?php

namespace Baron\Recombee\Commands;

use Illuminate\Console\Command;

class RecombeeCommand extends Command
{
    public $signature = 'laravel-recombee';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
