<?php

namespace App\Console\Commands;

use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReloadUniqueId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reload-unique-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload unique_id for all stores';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $stores = Store::all();

            foreach ($stores as $store) {
                do {
                    $uniqueId = strtoupper(Str::random(6));
                } while (Store::where('unique_id', $uniqueId)->exists());

                $store->unique_id = $uniqueId;
                $store->save();
            }

            $this->info('Unique IDs reloaded for all stores.');
        } catch (\Exception $e) {
            Log::error('Failed to reload unique IDs: ' . $e->getMessage());
            $this->error('Failed to reload unique IDs. Check logs for details.');
        }
        return 0;
    }
}
