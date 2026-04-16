<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:prune-inactive-locations')]
#[Description('Command description')]
class PruneInactiveLocations extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = \App\Models\Location::where('created_at', '<=', now()->subDays(14))
            ->where('upvotes_count', '<', 2)
            ->delete();

        $this->info("Terminé ! $count locations inactives ont été supprimées.");
    }
}
