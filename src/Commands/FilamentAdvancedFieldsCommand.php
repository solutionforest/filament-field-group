<?php

namespace SolutionForest\FilamentFieldGroup\Commands;

use Illuminate\Console\Command;

class FilamentFieldGroupCommand extends Command
{
    public $signature = 'filament-field-group';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
