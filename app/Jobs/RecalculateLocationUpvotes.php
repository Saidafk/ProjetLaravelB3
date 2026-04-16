<?php

namespace App\Jobs;

use App\Models\Location;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RecalculateLocationUpvotes implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public Location $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function handle(): void
    {
        $count = DB::table('location_votes')
            ->where('location_id', $this->location->id)
            ->count();

        $this->location->update(['upvotes_count' => $count]);
    }
}
