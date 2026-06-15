<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoCompleteOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:auto-complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically complete orders that have been shipped for more than 3 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoffDate = \Carbon\Carbon::now()->subDays(3);

        $updatedCount = \App\Models\Order::where('status', 'shipped')
            ->whereNotNull('shipped_at')
            ->where('shipped_at', '<=', $cutoffDate)
            ->update(['status' => 'completed']);

        $this->info("Auto-completed {$updatedCount} orders.");
    }
}
