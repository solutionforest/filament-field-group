<?php

namespace Solutionforest\FilamentAdvancedFields\Commands;

use Illuminate\Console\Command;

class FilamentAdvancedFieldsCommand extends Command
{
    public $signature = 'filament-advanced-fields';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
